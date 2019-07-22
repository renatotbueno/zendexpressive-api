<?php

declare(strict_types=1);

namespace Direction\Application\Service;

use Direction\Application\Service\PlaceApiService;
use Direction\Domain\Repository\DirectionPriceRepositoryInterface;
use Queuer\Builder\MessageBuilder;
use Direction\Application\Service\Partners\Rome2RioPartner;
use Direction\Console\Rome2RioSaveRoute;
use Direction\Domain\Collection\Rome2RioRouteCollection;
use Direction\Domain\Entity\Factory\Rome2RioCollectionFactory;
use Direction\Domain\Entity\Rome2RioRequest;
use Direction\Domain\Entity\Rome2RioRoute;

final class DirectionService
{
    /** @var Rome2RioService  */
    private $rome2RioService;

    /** @var GoogleDirectionService */
    private $googleDirectionService;

    /** @var MessageBuilder */
    private $messageBuilder;

    private $config;

    /**
     * @var PlaceApiService
     */
    private $placeApiService;

    /**
     * @var DirectionPriceRepositoryInterface
     */
    private $directionPriceRepo;

    /**
     * DirectionService constructor.
     * @param MessageBuilder $messageBuilder
     * @param $config
     * @param Rome2RioService $rome2RioService
     * @param GoogleDirectionService $googleDirectionService
     * @param \Direction\Application\Service\PlaceApiService $placeApiService
     * @param DirectionPriceRepositoryInterface $transportPriceRepo
     */
    public function __construct(
        MessageBuilder $messageBuilder,
        $config,
        Rome2RioService $rome2RioService,
        GoogleDirectionService $googleDirectionService,
        PlaceApiService $placeApiService,
        DirectionPriceRepositoryInterface $directionPriceRepo
    )
    {
        $this->messageBuilder = $messageBuilder;
        $this->googleDirectionService = $googleDirectionService;
        $this->config = $config;
        $this->rome2RioService = $rome2RioService;
        $this->placeApiService = $placeApiService;
        $this->directionPriceRepo = $directionPriceRepo;

    }

    /**
     * @param array $data
     * @return Rome2RioRouteCollection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRoutes(array $data)
    {
        #TODO alterar o endpoint nesse metodo ai de baixo que busca a geolocalizacao
        $routes = $this->rome2RioService->findRoutesByCities(
            $data['from_city_id'],
            $data['to_city_id']
        );

        if (!empty($routes)) {

            $collection = new Rome2RioRouteCollection();

            if ($routes) {

                /** @var Rome2RioRoute $route */
                foreach ($routes as $route) {

                    $collection->addItem(Rome2RioCollectionFactory::fromDatabaseSource($route));
                }
            }

        } else {

            $fromCity = $this->placeApiService->getCityById((int)$data['from_city_id']);
            $toCity = $this->placeApiService->getCityById((int)$data['to_city_id']);
           
            $cityResponse = [
                'origin_lat' => $fromCity['latitude'],
                'origin_lng' => $fromCity['longitude'],
                'dest_lat' => $toCity['latitude'],
                'dest_lng' => $toCity['longitude'],
                'language' => $data['locale'],
                'currency' => $data['currency']
            ];

            $rome2RioRequest = new Rome2RioRequest(
                $cityResponse['language'],
                $cityResponse['currency'],
                $cityResponse['origin_lat'], $cityResponse['origin_lng'],
                $cityResponse['dest_lat'], $cityResponse['dest_lng']
            );

            $rome2RioResponse = $this->rome2RioService->searchRome2Rio($rome2RioRequest);

            //preencher segmentos com a sua respectiva cidade ( city_id )
            $rome2RioResponse = $this->rome2RioService->fillCityOfSegments($rome2RioResponse, $data['from_city_id'], $data['to_city_id']);

            $collection = Rome2RioCollectionFactory::fromApiResponse($rome2RioResponse, $data);

//            if ($collection->count()) {
//
//                foreach ($collection as $route) {
//
//                    //TODO preencher os arquivos yml, add campos novos e criar arquivos das novas entidades
//                    $command = \Direction\Application\Command\Rome2RioSaveRoute::fromArray($route->toArray());
//                    $this->rome2RioService->save($command);
//                    dd($command);
//                    $this
//                        ->messageBuilder
//                        ->setCommand(Rome2RioSaveRoute::NAME)
//                        ->setTopic($this->config->sqs_queue_prefix . 'rome2rio-routes')
//                        ->setMessage($route->toArray())
//                        ->send();
//                }
//            }
        }

        return $collection;
    }

    public function getDirection(array $data)
    {
        return $this->googleDirectionService->getDirection($data);
    }

    /**
     * @param $cityId
     * @param $departureStop
     * @param $arrivalStop
     * @param $transportType
     * @param $numStops
     */
    public function getDirectionPrice(
        $cityId,
        $departureStop,
        $arrivalStop,
        $transportType,
        $numStops
    )
    {
        return $this->directionPriceRepo->getPrice(
            $cityId,
            $departureStop,
            $arrivalStop,
            $transportType,
            $numStops
        );
    }

    /**
     * @param $cityId
     * @param $departureStop
     * @param $arrivalStop
     * @param $transportType
     */
    public function getExclusivePriceByStation(
        $cityId,
        $departureStop,
        $arrivalStop,
        $transportType
    )
    {
        return $this->directionPriceRepo->getExclusivePriceByStation(
            $cityId,
            $departureStop,
            $arrivalStop,
            $transportType
        );
    }
}
