<?php

declare(strict_types=1);

namespace Direction\Domain\Repository;

interface DirectionPriceRepositoryInterface
{
    public function getPrice($cityId, $departureStop, $arrivalStop, $transportType, $numStops);

    public function getExclusivePriceByStation($cityId, $departureStop, $arrivalStop, $transportType);
}