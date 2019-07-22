<?php

declare(strict_types=1);

namespace Direction\Infrastructure\Container\Application\Factory;

use Direction\Application\Service\PlaceApiService;
use Psr\Container\ContainerInterface;

class PlaceApiServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return PlaceApiService
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        return new PlaceApiService( $config );
    }
}
