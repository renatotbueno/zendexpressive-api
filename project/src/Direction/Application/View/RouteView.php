<?php

namespace Direction\Application\View;

use Direction\Domain\Entity\Rome2RioRoute;
use Direction\Domain\Entity\Rome2RioRouteSegment;

/**
 * RouteView
 * @author Renato Teixeira Bueno <renatotbueno@gmail.com>
 */
class RouteView
{
    /**
     * @var string
     */
    private $name;
    private $distance;
    private $duration;
    private $transitDuration;
    private $transferDuration;

    /**
     * @var array
     */
    private $departurePlace;

    /**
     * @var array
     */
    private $arrivalPlace;

    private $fromCityId;
    private $toCityId;

    private $indicativePrice;

    private $segments;

    public function __construct(
        $name,
        $distance,
        $duration,
        $transitDuration,
        $transferDuration,
        $departurePlace,
        $arrivalPlace,
        $fromCityId,
        $toCityId,
        $indicativePrice,
        $segments
    )
    {
        $this->name = $name;
        $this->distance = $distance;
        $this->duration = $duration;
        $this->transitDuration = $transitDuration;
        $this->transferDuration = $transferDuration;
        $this->departurePlace = $departurePlace;
        $this->arrivalPlace = $arrivalPlace;
        $this->fromCityId = (int) $fromCityId;
        $this->toCityId = (int) $toCityId;
        $this->indicativePrice = $indicativePrice;
        $this->segments = $segments;
    }

    /**
     * @param Rome2RioRoute $route
     * @return RouteView
     */
    public static function fromDatabase(Rome2RioRoute $route)
    {
        $routeSegments = $route->getSegments()->toArray();

        if ($routeSegments) {

            /**
             * @var Rome2RioRouteSegment $segment
             */
            foreach ($routeSegments as $segment) {

                $segments[] = [
                    'city_id' => $segment->getCityId(),
                    'segmentKind' => $segment->getSegmentKind(),
                    'distance' => $segment->getDistance(),
                    'duration' => $segment->getDuration(),
                    'transferDuration' => $segment->getTransferDuration(),
                    'indicativePrice' => [
                        'price' => $segment->getPrice(),
                        'currency' => $segment->getCurrency(),
                        'priceLow' => $segment->getPriceLow(),
                        'priceHigh' => $segment->getPriceHigh()
                    ],
                    'depPlace' => [
                        'kind' => $segment->getDepPlaceKind(),
                        'lat' => $segment->getDepPlaceLat(),
                        'lng' => $segment->getDepPlaceLng(),
                        'shortName' => $segment->getDepPlaceShortname()
                    ],
                    'arrPlace' => [
                        'kind' => $segment->getArrPlaceKind(),
                        'lat' => $segment->getArrPlaceLat(),
                        'lng' => $segment->getArrPlaceLng(),
                        'shortName' => $segment->getArrPlaceShortname()
                    ],
                    'vehicle' => [
                        'kind' => strtolower($segment->getVehicleKind()),
                        'name' => $segment->getVehicleName()
                    ],
                    'path' => $segment->getPath()
                ];
            }
        }

        return new static(
            $route->getName(),
            $route->getDistance(),
            $route->getTotalDuration(),
            0,
            $route->getTotalTransferDuration(),
            [],
            [],
            $route->getOriginCityId(),
            $route->getDestinationCityId(),
            [
                'price' => $route->getPrice(),
                'currency' => $route->getCurrency(),
                'priceLow' => $route->getPriceLow(),
                'priceHigh' => $route->getPriceHigh()
            ],
            $segments
        );
    }

    public static function fromApiResponse(array $route, $apiDataRequest)
    {
        $indicativePrice = [
            'price' => $route['indicativePrice']['price'],
            'currency' => $route['indicativePrice']['currency'],
            'priceLow' => $route['indicativePrice']['priceLow'],
            'priceHigh' => $route['indicativePrice']['priceHigh']
        ];

        $segments = [];

        if (isset($route['segments'])) {

            foreach ($route['segments'] as $segment) {

                $agencies = [];
                if ($segment['agencies']) {

                    foreach ($segment['agencies'] as $agency) {

                        $link = [
                            'text' => '',
                            'url' => '',
                            'displayUrl' => ''
                        ];

                        if ( isset($agency['links']) ) {
                            $link = current($agency['links']);
                        }

                        $agencies[] = [
                            'name' => $agency['name'],
                            'url' => $agency['url'],
                            'phone' => $agency['phone'],
                            'icon_url' => isset($agency['icon']['url']) ? $agency['icon']['url'] : '',
                            'frequency' => $agency['frequency'],
                            'duration' => $agency['duration'],
                            'link' => $link
                        ];
                    }

                    $segment['agencies'] = $agencies;
                }

                $segment['indicativePrice'] = $segment['indicativePrices'];

                /**
                 * removedo por n precisa por enquanto
                 */
                unset($segment['indicativePrices']);

                $segments[] = $segment;
            }

        }

        return new static(
            $route['name'],
            $route['distance'],
            $route['totalDuration'],
            $route['totalTransitDuration'],
            $route['totalTransferDuration'],
            $route['depPlace'],
            $route['arrPlace'],
            $apiDataRequest['from_city_id'],
            $apiDataRequest['to_city_id'],
            $indicativePrice,
            $segments
        );
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'distance' => $this->distance,
            'transitDuration' => $this->transitDuration,
            'transferDuration' => $this->transferDuration,
            'departurePlace' => $this->departurePlace,
            'arrivalPlace' => $this->arrivalPlace,
            'fromCityId' => $this->fromCityId,
            'toCityId' => $this->toCityId,
            'indicativePrice' => $this->indicativePrice,
            'segments' => $this->segments
        ];
    }
}
