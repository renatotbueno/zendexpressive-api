<?php

namespace Direction\Http\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Direction\Application\Service\DirectionService;
use Webmozart\Assert\Assert;
use Zend\Diactoros\Response\JsonResponse;

class GetDirectionPriceAction
    implements MiddlewareInterface
{
    /**
     * @var DirectionService
     */
    private $directionService;

    public function __construct(DirectionService $directionService)
    {
        $this->directionService = $directionService;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return \Psr\Http\Message\ResponseInterface|JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
	    $data = json_decode($request->getBody()->getContents(), true);

	    Assert::notEmpty($data['city_id'], 'city_id not found');

	    /** @var array $price */
        $price = $this->directionService->getDirectionPrice(
            $data['city_id'],
            $data['departure_stop'],
            $data['arrival_stop'],
            $data['transport_type'],
            $data['num_stops']
        );

        $exclusivePrice = $this->directionService->getExclusivePriceByStation(
            $data['city_id'],
            $data['departure_stop'],
            $data['arrival_stop'],
            $data['transport_type']
        );

        $price['exclusive_price'] = false;
        if ($exclusivePrice) {
            $price = $exclusivePrice;
            $price['exclusive_price'] = true;
        }

        return new JsonResponse($price, 202);
    }
}
