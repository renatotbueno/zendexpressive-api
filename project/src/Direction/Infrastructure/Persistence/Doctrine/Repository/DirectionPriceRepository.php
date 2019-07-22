<?php

declare(strict_types=1);

namespace Direction\Infrastructure\Persistence\Doctrine\Repository;

use Direction\Domain\Repository\DirectionPriceRepositoryInterface;
use Jettyn\Core\Doctrine\AbstractDoctrineRepository;

final class DirectionPriceRepository extends AbstractDoctrineRepository implements DirectionPriceRepositoryInterface
{
    protected function getAlias()
    {
        return 'tp';
    }

    /**
     * @param $cityId
     * @param $departureStop
     * @param $arrivalStop
     * @param $transportType
     * @param $numStops
     * @return mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getPrice($cityId, $departureStop, $arrivalStop, $transportType, $numStops)
    {
        $departureStop = addslashes($departureStop);
        $arrivalStop = addslashes($arrivalStop);
        $sql = "SELECT * FROM direction_price
                WHERE TRUE
                    AND city_id = $cityId
                    and type in ('$transportType', 'ALL')
                    AND (
                          (station = '$departureStop' OR station is null)
                          OR 
                          (station = '$arrivalStop' OR station is null)
                        )
                    and quantity_tickets = 1
                    and (stops >= $numStops OR stops is null)
                ORDER BY
                    station desc, price asc
                LIMIT 1;";

        $sth = $this->_em->getConnection()->prepare($sql);
        $sth->execute();

        return $sth->fetch();
    }

    /**
     * @param $cityId
     * @param $departureStop
     * @param $arrivalStop
     * @param $transportType
     * @return mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getExclusivePriceByStation($cityId, $departureStop, $arrivalStop, $transportType)
    {
        $departureStop = addslashes($departureStop);
        $arrivalStop = addslashes($arrivalStop);
        $sql = "SELECT * FROM direction_price
                WHERE TRUE
                    AND city_id = $cityId
                    and type in ('$transportType', 'ALL')
                    AND (
                          (station = '$departureStop')
                          OR 
                          (station = '$arrivalStop')
                        )
                    and quantity_tickets = 1
                ORDER BY
                    station desc, price asc
                LIMIT 1;";

        $sth = $this->_em->getConnection()->executeQuery($sql);
        return $sth->fetch();
    }
}