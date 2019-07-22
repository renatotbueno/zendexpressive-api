<?php

declare(strict_types=1);

namespace Direction\Infrastructure\Container\Application\Factory;

use Direction\Application\Handler\Rome2RioSaveRouteCommandHandler;
use Direction\Application\Service\Rome2RioService;
use Psr\Container\ContainerInterface;

class Rome2RioSaveRouteCommandHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return Rome2RioSaveRouteCommandHandler
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container)
    {
        $rome2RioService = $container->get(Rome2RioService::class);
        return new Rome2RioSaveRouteCommandHandler($rome2RioService);
    }
}
