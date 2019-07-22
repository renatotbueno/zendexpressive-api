<?php

declare(strict_types=1);

namespace Direction\Application\Service;

use Direction\Application\Service\Partners\GoogleDirectionPartner;
use Direction\Domain\Entity\Factory\GoogleDirectionCollectionFactory;
use Direction\Domain\Entity\GoogleDirectionRequest;

final class GoogleDirectionService
{

    /** @var  GoogleDirectionPartner $googleDirectionPartner */
    private $googleDirectionPartner;
    private $config;

    public function __construct(
        $config,
        GoogleDirectionPartner $googleDirectionPartner
    )
    {
        $this->config = $config;
        $this->googleDirectionPartner = $googleDirectionPartner;
    }

    public function getDirection(array $data)
    {
        $googleDirectionRequest = new GoogleDirectionRequest(
            $data['from_lat'], $data['from_lng'],
            $data['to_lat'], $data['to_lng'],
            $data['mode'],
            $data['language'],
            $data['departure_time']
        );

        $response = $this->googleDirectionPartner->getDirection($googleDirectionRequest);

        $routeCollection = GoogleDirectionCollectionFactory::fromApiResponse($response);

        /**
         * Valida se a distancia for maior que 1.5km entao refazemos a pesquisa com mode=transit
         * por default passamos walking
         */
        $firstRoute = ($routeCollection) ? $routeCollection[0] : null;

        $firstLeg = ($firstRoute) ? $firstRoute->legs()[0] : null;
        $distance = ($firstLeg) ? $firstLeg->distance()['value'] : 5000;
        if ($distance >= 1500) {

            $googleDirectionRequest = new GoogleDirectionRequest(
                $data['from_lat'], $data['from_lng'],
                $data['to_lat'], $data['to_lng'],
                'transit',
                $data['language'],
                $data['departure_time']
            );

            $response = $this->googleDirectionPartner->getDirection($googleDirectionRequest);

            $routeCollection = GoogleDirectionCollectionFactory::fromApiResponse($response);

            if (!$routeCollection->count()) {

                $googleDirectionRequest = new GoogleDirectionRequest(
                    $data['from_lat'], $data['from_lng'],
                    $data['to_lat'], $data['to_lng'],
                    'driving',
                    $data['language'],
                    $data['departure_time']
                );

                $response = $this->googleDirectionPartner->getDirection($googleDirectionRequest);
                $routeCollection = GoogleDirectionCollectionFactory::fromApiResponse($response);
            }
        }

        return $routeCollection;
    }

}
