<?php

namespace Direction\Domain\Entity\Factory;

use Direction\Application\View\FlightAgentView;
use Direction\Application\View\FlightBookingDetailsLinkView;
use Direction\Application\View\FlightCarrierView;
use Direction\Application\View\FlightCurrencyView;
use Direction\Application\View\FlightItineraryView;
use Direction\Application\View\FlightPlaceView;
use Direction\Application\View\FlightPrincingOptionView;
use Direction\Application\View\FlightSegmentView;
use Direction\Application\View\FlightView;
use Direction\Application\View\DirectionLegView;
use Direction\Application\View\DirectionLineView;
use Direction\Application\View\DirectionRouteView;
use Direction\Application\View\DirectionStepView;
use Direction\Application\View\GoogleDirectionTransitDetailsView;
use Direction\Application\View\GoogleDirectionVechicleView;
use Direction\Domain\Collection\FlightItineraryCollection;
use Direction\Domain\Collection\GoogleDirectionLegCollection;
use Direction\Domain\Collection\GoogleDirectionRouteCollection;
use Direction\Domain\Collection\GoogleDirectionStepCollection;

class GoogleDirectionCollectionFactory {

    /**
     * @param $response
     * @return GoogleDirectionRouteCollection
     */
    public static function fromApiResponse($response)
    {
        $routeCollection = new GoogleDirectionRouteCollection();

        if (!empty($response) && isset($response['routes']) && !empty($response['routes'])) {

            $routes = GoogleDirectionCollectionFactory::orderRoutesByRouteTime($response['routes']);

            $routeCollection = new GoogleDirectionRouteCollection();

            foreach ($routes as $route) {

                $legCollection = new GoogleDirectionLegCollection();

                foreach ($route['legs'] as $leg) {

                    $stepCollection = new GoogleDirectionStepCollection();

                    foreach ($leg['steps'] as $step) {

                        $vehicle = GoogleDirectionVechicleView::fromApiResponse(
                            isset($step['transit_details']['line']['vehicle']) ?
                                $step['transit_details']['line']['vehicle'] : []);

                        $line = DirectionLineView::fromApiResponse(
                            isset($step['transit_details']['line']) ?
                                $step['transit_details']['line'] : [],
                            $vehicle
                        );

                        $transitDetails = GoogleDirectionTransitDetailsView::fromApiResponse(
                            isset($step['transit_details']) ?
                                $step['transit_details'] : [],
                            $line);

                        $stepStepCollection = new GoogleDirectionStepCollection();
                        if (isset($step['steps'])) {

                            foreach ($step['steps'] as $stepStep) {
                                $stepStepView = DirectionStepView::fromApiResponse($stepStep);
                                $stepStepCollection->addItem($stepStepView);
                            }

                        }

                        $stepView = DirectionStepView::fromApiResponse($step, $transitDetails, $stepStepCollection);
                        $stepCollection->addItem($stepView);
                    }

                    $legView = DirectionLegView::fromApiResponse($leg, $stepCollection);

                    $legCollection->addItem($legView);
                }

                $routeView = DirectionRouteView::fromApiResponse($route, $legCollection);

                $routeCollection->addItem($routeView);
            }
        }

        return $routeCollection;
    }

    /**
     * @param $routes
     * @return mixed
     */
    public static function orderRoutesByRouteTime($routes)
    {
        for($i=count($routes)-1; $i >= 1; $i--)
        {
            for($j=0; $j < $i ; $j++)
            {
                if (isset($routes[$j]->legs[0]) && $routes[$j+1]->legs[0]) {

                    $firstDuration = $routes[$j]->legs[0]->duration->value;
                    $secondDuration = $routes[$j+1]->legs[0]->duration->value;

                    if($firstDuration > $secondDuration)
                    {
                        $routeAux = $routes[$j];
                        $routes[$j] = $routes[$j+1];
                        $routes[$j+1] = $routeAux;
                    }
                }
            }
        }

        return $routes;
    }

}