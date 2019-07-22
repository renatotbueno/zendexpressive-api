<?php

declare(strict_types=1);

namespace Direction\Infrastructure\Container\Infrastructure;

use Broadway\CommandHandling\SimpleCommandBus;
use Interop\Container\ContainerInterface;
use Jettyn\Core\ServiceBus\Adapter\BroadwayCommandBus;
use Jettyn\Core\ServiceBus\Adapter\BroadwayCommandBusMiddleware;
use Jettyn\Core\ServiceBus\CommandBus\CommandBusSupportingMiddleware;
use Jettyn\Core\ServiceBus\CommandBus\InjectCommandBusTrait;
use Jettyn\Core\ServiceBus\EventBus\InjectEventBusTrait;
use Jettyn\Core\ServiceBus\EventBusInterface;
use Jettyn\Core\Middleware\LogCommandsMiddleware;
use Jettyn\Core\Middleware\TransactionalMiddleware;

final class CommandBusFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $handlers           = $container->get('config')['command_bus']['handlers'];
        $broadwayCommandBus = new BroadwayCommandBus(new SimpleCommandBus);
        $services           = [];

        foreach ($handlers as $handlerService) {
            array_push($services, $container->get($handlerService));
        }

        foreach ($services as $service) {
            $broadwayCommandBus->subscribe($service);
        }

        $commandBusMiddleware = new CommandBusSupportingMiddleware;
        $commandBusMiddleware->appendMiddleware(new LogCommandsMiddleware($container->get('logger')));
        $commandBusMiddleware->appendMiddleware(new TransactionalMiddleware(
            $container->get('doctrine.entity_manager.orm_default')
        ));
        $commandBusMiddleware->appendMiddleware(new BroadwayCommandBusMiddleware($broadwayCommandBus));

        // inject command bus
        foreach ($services as $service) {
            foreach (class_uses($service) as $trait) {
                if ($trait !== InjectCommandBusTrait::class) {
                    continue;
                }

                $service->setCommandBus($commandBusMiddleware);
            }
        }

        // inject event bus
        foreach ($services as $service) {
            foreach (class_uses($service) as $trait) {
                if ($trait !== InjectEventBusTrait::class) {
                    continue;
                }

                $service->setEventBus($container->get(EventBusInterface::NAME));
            }
        }

        return $commandBusMiddleware;
    }
}
