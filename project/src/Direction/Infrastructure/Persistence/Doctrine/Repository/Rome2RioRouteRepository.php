<?php

declare(strict_types=1);

namespace Direction\Infrastructure\Persistence\Doctrine\Repository;

use Direction\Domain\Entity\Rome2RioRoute;
use Direction\Domain\Repository\Rome2RioRouteRepositoryInterface;
use Jettyn\Core\Doctrine\AbstractDoctrineRepository;

final class Rome2RioRouteRepository extends AbstractDoctrineRepository implements Rome2RioRouteRepositoryInterface
{
    protected function getAlias()
    {
        return 't';
    }

    public function findRoutesByCities($fromCityId, $toCityId)
    {
        $result = $this->findBy([
            'originCityId' => $fromCityId,
            'destinationCityId' => $toCityId
        ]);

        return $result;
    }

    public function save(Rome2RioRoute $route)
    {
        $this->_em->persist($route);
        $this->_em->flush();
    }

    public function update()
    {
        $this->_em->flush();
    }

}