<?php

declare(strict_types=1);

namespace Direction\Infrastructure\Container\Application\Factory;

use Direction\Application\Service\Partners\Rome2RioPartner;
use Direction\Application\Service\PlaceApiService;
use Direction\Application\Service\Rome2RioService;
use Direction\Domain\Entity\Rome2RioRoute;
use Direction\Domain\Repository\Rome2RioRouteRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class Rome2RioServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return Rome2RioService
     */
    public function __invoke(ContainerInterface $container)
    {

        /** @var EntityManager $em */
        $em = $container->get('doctrine.entity_manager.orm_default');

        try {
            /** @var Rome2RioRouteRepositoryInterface $repository */
            $repository = $em->getRepository(Rome2RioRoute::class);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        

        $rome2RioPartner = $container->get(Rome2RioPartner::class);
        $placeApiService = $container->get(PlaceApiService::class);

        $config = $container->get('config');

        return new Rome2RioService($repository, $config, $rome2RioPartner, $placeApiService);
    }
}
