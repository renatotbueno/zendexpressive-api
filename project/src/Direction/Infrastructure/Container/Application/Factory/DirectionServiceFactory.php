<?php

declare(strict_types=1);

namespace Direction\Infrastructure\Container\Application\Factory;

use Direction\Application\Service\PlaceApiService;
use Direction\Application\Service\GoogleDirectionService;
use Direction\Application\Service\Rome2RioService;
use Direction\Application\Service\DirectionService;
use Direction\Domain\Entity\DirectionPrice;
use Direction\Domain\Repository\DirectionPriceRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class DirectionServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return DirectionService
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container)
    {
        try {

            /** @var EntityManager $em */
            $em = $container->get('doctrine.entity_manager.orm_default');

            $messageBuilder = $container->get('messageBuilder');
            $rome2RioService = $container->get(Rome2RioService::class);
            $googleDirectionService = $container->get(GoogleDirectionService::class);
            $placeService = $container->get(PlaceApiService::class);
            $config = $container->get('config');

            /** @var DirectionPriceRepositoryInterface $directionPriceRepo */
            $directionPriceRepo = $em->getRepository(DirectionPrice::class);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return new DirectionService(
            $messageBuilder,
            $config,
            $rome2RioService,
            $googleDirectionService,
            $placeService,
            $directionPriceRepo
        );
    }
}
