<?php

declare(strict_types=1);

namespace Direction\Infrastructure\Container\Application\Factory;

use Direction\Application\Service\Partners\GoogleDirectionPartner;
use Psr\Container\ContainerInterface;

class GoogleDirectionPartnerFactory
{
    /**
     * @param ContainerInterface $container
     * @return GoogleDirectionPartner
     */
    public function __invoke(ContainerInterface $container)
    {
        return new GoogleDirectionPartner();
    }
}
