<?php

declare(strict_types=1);

namespace Direction\Infrastructure\Container\Application\Factory;

use Direction\Application\Service\GoogleDirectionService;
use Direction\Application\Service\Partners\GoogleDirectionPartner;
use Psr\Container\ContainerInterface;

class GoogleDirectionServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return GoogleDirectionService
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container)
    {
        $googleDirectionPartner = $container->get(GoogleDirectionPartner::class);

        $config = $container->get('config');

        return new GoogleDirectionService($config, $googleDirectionPartner);
    }
}
