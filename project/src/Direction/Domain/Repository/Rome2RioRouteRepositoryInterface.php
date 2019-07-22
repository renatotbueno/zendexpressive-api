<?php

declare(strict_types=1);

namespace Direction\Domain\Repository;

use Direction\Domain\Entity\Rome2RioRoute;

interface Rome2RioRouteRepositoryInterface
{
    public function findRoutesByCities($fromCityId, $toCityId);

    public function save(Rome2RioRoute $route);

    public function update();
}