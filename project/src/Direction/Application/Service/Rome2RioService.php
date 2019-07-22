<?php

declare(strict_types=1);

namespace Direction\Application\Service;

use GuzzleHttp\Client;
use Direction\Application\Command\Rome2RioSaveRoute;
use Direction\Application\Service\Partners\Rome2RioPartner;
use Direction\Domain\Entity\Rome2RioRequest;
use Direction\Domain\Entity\Rome2RioRoute;
use Direction\Domain\Repository\Rome2RioRouteRepositoryInterface;

final class Rome2RioService
{
    /** @var Rome2RioRouteRepositoryInterface $repository  */
    private $repository;

    /** @var Rome2RioPartner  */
    private $rome2RioPartner;

    private $config;

    /**
     * @var
     */
    private $placeApiService;

    public function __construct(
        Rome2RioRouteRepositoryInterface $repository,
        $config,
        Rome2RioPartner $rome2RioPartner,
        PlaceApiService $placeApiService
    )
    {
        $this->rome2RioPartner = $rome2RioPartner;
        $this->repository = $repository;
        $this->config = $config;
        $this->placeApiService = $placeApiService;
    }

    /**
     * @param Rome2RioSaveRoute $routeCommand
     */
    public function save(Rome2RioSaveRoute $routeCommand)
    {
        $route = new Rome2RioRoute(
            $routeCommand->getOriginCityId(),
            $routeCommand->getDestinationCityId(),
            $routeCommand->getName(),
            $routeCommand->getDistance(),
            $routeCommand->getTotalDuration(),
            $routeCommand->getTotalTransferDuration(),
            $routeCommand->getPrice(),
            $routeCommand->getPriceLow(),
            $routeCommand->getPriceHigh(),
            $routeCommand->getCurrency()
        );

        if ($routeCommand->getSegments()) {
            foreach ($routeCommand->getSegments() as $segment) {
                $route->addSegment($segment);
            }
        }

        $this->repository->save($route);

        dd('salvou???');
    }

    public function findRoutesByCities($fromCityId, $toCityId)
    {
        return $this->repository->findRoutesByCities($fromCityId, $toCityId);
    }

    /**
     * @param Rome2RioRequest $rome2RioRequest
     * @return array|\Direction\Domain\Collection\Rome2RioRouteCollection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function searchRome2Rio(Rome2RioRequest $rome2RioRequest)
    {
        try {

            $response = $this->rome2RioPartner->search($rome2RioRequest);


            if (!empty($response)) {

                $response = json_decode($response->getBody()->getContents(), true);

                $agencies = (array_key_exists('agencies', $response)) ? $response['agencies'] : [];
                $vehicles = (array_key_exists('vehicles', $response)) ? $response['vehicles'] : [];
                $places = (array_key_exists('places', $response)) ? $response['places'] : [];
                $airlines = (array_key_exists('airlines', $response)) ? $response['airlines'] : [];
                $aircrafts = (array_key_exists('aircrafts', $response)) ? $response['aircrafts'] : [];
                $routes = (array_key_exists('routes', $response)) ? $response['routes'] : [];


                return [
                    'agencies' => $agencies,
                    'vehicles' => $vehicles,
                    'places' => $places,
                    'airlines' => $airlines,
                    'aircrafts' => $aircrafts,
                    'routes' => $routes
                ];
            }

            return [];

        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * @param $rome2rioResponse
     * @param $origin_city_id
     * @param $destination_city_id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fillCityOfSegments($rome2rioResponse, $origin_city_id, $destination_city_id)
    {
        $routes = [];
        if ( array_key_exists('routes', $rome2rioResponse) ) {

            $routes = $rome2rioResponse['routes'];

            $places = (array_key_exists('places', $rome2rioResponse)) ? $rome2rioResponse['places'] : [];

            foreach ($routes as $keyRoute => $route) {

                $route = (array) $route;

                if (isset($route['segments'])) {

                    foreach ($route['segments'] as $keySegment => $segment) {

                        $segment = (array) $segment;
                        $depPlace =  $places[$segment['depPlace']];

                        $depPlaceLat = $depPlace['lat'];
                        $depPlaceLng = $depPlace['lng'];

                        try {

                            $city = $this->placeApiService->getCityByGeocoding($depPlaceLat, $depPlaceLng);

                            if ( !$city ) {
                                $step_city_id = $destination_city_id;
                            } else {
                                $step_city_id = $city['city_id'];
                            }

                            /**
                             * Caso o roteiro encontre na rota mais de 1 cidade que nao sejam a cidade de partida e destino
                             * definimos os steps dessa cidade auxiliar como se fossem da cidade de partida
                             */
                            if ($step_city_id != $destination_city_id) {
                                $step_city_id = $origin_city_id;
                            }

                            $segment['city_id'] = $step_city_id;

                        } catch (\Exception $e) {
                            $segment['city_id'] = $origin_city_id;
                        }

                        $route['segments'][$keySegment] = $segment;
                    }
                }

                $routes[$keyRoute] = $route;
            }
        }

        $rome2rioResponse['routes'] = $routes;

        return $rome2rioResponse;
    }
}
