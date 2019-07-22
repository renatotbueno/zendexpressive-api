<?php

namespace Direction\Infrastructure\Container\Application\Action;

use Assert\Assertion;
use Jettyn\Core\ServiceBus\CommandBusInterface;
use Psr\Container\ContainerInterface;

class DirectionActionFactory
{
    public function __invoke(ContainerInterface $container, $requestedService)
    {
        Assertion::classExists($requestedService);

        return new $requestedService($container->get(CommandBusInterface::NAME));
    }
}
