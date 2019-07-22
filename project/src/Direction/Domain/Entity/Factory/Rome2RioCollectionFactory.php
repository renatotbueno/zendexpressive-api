<?php

namespace Direction\Domain\Entity\Factory;

use Direction\Application\View\Rome2RioFlightSegmentView;
use Direction\Application\View\Rome2RioFlightView;
use Direction\Application\View\RouteView;
use Direction\Domain\Collection\Rome2RioRouteCollection;
use Direction\Domain\Entity\Rome2RioRoute;

class Rome2RioCollectionFactory {

    /**
     * @param Rome2RioRoute $route
     * @param array $segments
     */
    public static function fromDatabaseSource(Rome2RioRoute $route)
    {
        return RouteView::fromDatabase($route);
    }

    public static function fromApiResponse($response, $apiDataRequest)
    {
        $agencies = (array_key_exists('agencies', $response)) ? $response['agencies'] : [];
        $vehicles = (array_key_exists('vehicles', $response)) ? $response['vehicles'] : [];
        $places = (array_key_exists('places', $response)) ? $response['places'] : [];
        $airlines = (array_key_exists('airlines', $response)) ? $response['airlines'] : [];
        $aircrafts = (array_key_exists('aircrafts', $response)) ? $response['aircrafts'] : [];

        $collection = new Rome2RioRouteCollection();

        if (array_key_exists('routes', $response)) {

            $routes = $response['routes'];

            if ( $routes ) {

                foreach ( $routes as $r ) {

                    $r = (array) $r;
                    $route = Rome2RioCollectionFactory::fromResponse(
                        $r,
                        $agencies,
                        $vehicles,
                        $places,
                        $airlines,
                        $aircrafts
                    );

                    $collection->addItem(RouteView::fromApiResponse($route, $apiDataRequest));
                }

            }
        }

        return $collection;
    }

    /**
     * @param $route
     * @param $agencies
     * @param $vehicles
     * @param $places
     * @param $airlines
     * @param $aircrafts
     * @return array
     */
    protected static function fromResponse(
        $route,
        $agencies,
        $vehicles,
        $places,
        $airlines,
        $aircrafts
    )
    {
        $responseRoute = [
            'name' => $route['name'],
            'distance' => $route['distance'],
            'totalDuration' => $route['totalDuration'],
            'totalTransitDuration' => $route['totalTransitDuration'],
            'totalTransferDuration' => $route['totalTransferDuration'],
        ];

        if ( isset($places[$route['depPlace']]) && !empty($places[$route['depPlace']]) ) {

            $depPlace = (array) $places[$route['depPlace']];

            $responseRoute['depPlace'] = $depPlace;
        }

        if ( isset($places[$route['arrPlace']]) && !empty($places[$route['arrPlace']]) ) {

            $arrPlace = (array) $places[$route['arrPlace']];

            $responseRoute['arrPlace'] = $arrPlace;
        }

        $indicativePrice = !empty($route['indicativePrices']) ? (array) current($route['indicativePrices']) : [
            "price" => '',
            "priceLow" => '',
            "priceHigh" => '',
            "currency" => ''
        ];

        $responseRoute['indicativePrice'] = $indicativePrice;

        $segs = [];
        if ( $route['segments'] ) {

            foreach ( $route['segments'] as $segment ) {

                $segment = (array) $segment;

                $indicativePrice = !empty($segment['indicativePrices']) ? (array) current($segment['indicativePrices']) : null;

                if ($indicativePrice) {
                    $segment['indicativePrice'] = $indicativePrice;
                }

                $outbound = !empty($segment['outbound']) ? $segment['outbound'] : null;

                if ($outbound) {

                    foreach ($outbound as $outboundKey => $outboundItem) {

                        $outboundItem = (array) $outboundItem;

                        array_walk_recursive($outboundItem, function(&$item, $key){

                            if (!in_array(gettype($key), ['string']))
                                $item = (array) $item;
                        });

                        $outbound[$outboundKey] = $outboundItem;
                    }

                    foreach ($outbound as $key => $value) {
                        $hops = $value['hops'];
                        foreach ($hops as $keyHop => $hop) {

                            $hops[$keyHop]['depPlace'] = $places[$hop['depPlace']];
                            $hops[$keyHop]['arrPlace'] = $places[$hop['arrPlace']];

                            $hops[$keyHop]['airline'] = isset($airlines[$hop['airline']]) ? $airlines[$hop['airline']] : $hop['airline'];
                            $hops[$keyHop]['aircraft'] = isset($aircrafts[$hop['aircraft']]) ? $aircrafts[$hop['aircraft']] : $hop['aircraft'];

                            if ($hop['codeshares']) {
                                $codeshares = $hop['codeshares'];
                                foreach ($codeshares as $keyCodeshare => $codeshare) {
                                    $codeshares[$keyCodeshare]['airline'] = isset($airlines[$codeshare['airline']]) ? $airlines[$codeshare['airline']] : $codeshare['airline'];
                                }
                                $hops[$keyHop]['codeshares'] = $codeshares;
                            }
                        }
                        $outbound[$key]['hops'] = $hops;
                    }

                    $outboundSegments = [];
                    foreach ($outbound as $key => $value) {
                        $outboundSegments[] = Rome2RioFlightSegmentView::fromApiResponse($value)->toArray();
                    }

                    $segment['outbound'] = $outboundSegments;
                }

                $inbound = !empty($segment['return']) ? $segment['return'] : null;

                if ($inbound) {

                    foreach ($inbound as $inboundKey => $inboundItem) {

                        $inboundItem = (array) $inboundItem;
                        array_walk_recursive($inboundItem, function(&$item, $key){

                            if (!in_array(gettype($key), ['string']))
                                $item = (array) $item;
                        });
                        $inbound[$inboundKey] = $inboundItem;
                    }

                    foreach ($inbound as $key => $value) {
                        $hops = $value['hops'];
                        foreach ($hops as $keyHop => $hop) {

                            $hops[$keyHop]['depPlace'] = $places[$hop['depPlace']];
                            $hops[$keyHop]['arrPlace'] = $places[$hop['arrPlace']];

                            $hops[$keyHop]['airline'] = isset($airlines[$hop['airline']]) ? $airlines[$hop['airline']] : $hop['airline'];
                            $hops[$keyHop]['aircraft'] = isset($aircrafts[$hop['aircraft']]) ? $aircrafts[$hop['aircraft']] : $hop['aircraft'];

                            if ($hop['codeshares']) {
                                $codeshares = $hop['codeshares'];
                                foreach ($codeshares as $keyCodeshare => $codeshare) {
                                    $codeshares[$keyCodeshare]['airline'] = isset($airlines[$codeshare['airline']]) ? $airlines[$codeshare['airline']] : $codeshare['airline'];
                                }
                                $hops[$keyHop]['codeshares'] = $codeshares;
                            }
                        }
                        $inbound[$key]['hops'] = $hops;
                    }

                    $inboundSegments = [];
                    foreach ($inbound as $key => $value) {
                        $inboundSegments[] = Rome2RioFlightSegmentView::fromApiResponse($value)->toArray();
                    }

                    $segment['return'] = $inboundSegments;
                }

                if ( !empty($vehicles[$segment['vehicle']]) ) {

                    $vehicle = (array) $vehicles[$segment['vehicle']];

                    $segment['vehicle'] = $vehicle;
                }

                if ( isset($places[$segment['depPlace']]) && !empty($places[$segment['depPlace']]) ) {

                    $depPlace = (array) $places[$segment['depPlace']];

                    $segment['depPlace'] = $depPlace;
                }

                if ( isset($places[$segment['arrPlace']]) && !empty($places[$segment['arrPlace']]) ) {

                    $arrPlace = (array) $places[$segment['arrPlace']];

                    $segment['arrPlace'] = $arrPlace;
                }

                $stops = [];

                if ( isset($segment['stops']) && !empty($segment['stops']) ) {

                    foreach ( $segment['stops'] as $stop ) {

                        $stop = (array) $stop;

                        if ( isset($places[$stop['place']]) && !empty($places[$stop['place']]) ) {

                            $stopPlace = (array) $places[$stop['place']];
                            $stop['place'] = $stopPlace;
                        }

                        $stops[] = $stop;
                    }
                }

                $segment['stops'] = $stops;

                /**
                 * agencies
                 */
                $agcies = [];
                if ( isset($segment['agencies']) && !emptY($segment['agencies']) ) {

                    foreach ( $segment['agencies'] as $agency ) {

                        $agency = (array) $agency;

                        if ( !empty($agencies[$agency['agency']])) {
                            $a = (array) $agencies[$agency['agency']];
                            $agency['agency'] = $a;
                        }

                        $links = [];
                        if ( isset($agency['links']) ) {

                            foreach ( $agency['links'] as $link ) {

                                $link = (array) $link;
                                $links[] = (array) $link;
                            }
                        }

                        $agency['links'] = $links;
                        $agency['agency']['icon'] = (array) $agency['agency']['icon'];

                        $agcies[] = $agency['agency'];
                    }
                }

                $segment['agencies'] = $agcies;
                $segs[] = $segment;
            }
        }

        $responseRoute['segments'] = $segs;

        return $responseRoute;
    }

}
