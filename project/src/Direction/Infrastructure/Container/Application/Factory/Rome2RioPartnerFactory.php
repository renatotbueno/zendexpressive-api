<?php

declare(strict_types=1);

namespace Direction\Infrastructure\Container\Application\Factory;

use Direction\Application\Service\Partners\Rome2RioPartner;
use Psr\Container\ContainerInterface;

class Rome2RioPartnerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Rome2RioPartner();
    }
}
