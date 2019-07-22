<?php

declare(strict_types=1);

namespace Direction\Domain\Repository;

interface Rome2RioRouteSegmentRepositoryInterface
{
    public function findSegmentsByRoute($routeId);
}