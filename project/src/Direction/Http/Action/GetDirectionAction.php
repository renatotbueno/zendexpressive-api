<?php

namespace Direction\Http\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Direction\Application\Service\DirectionService;
use Zend\Diactoros\Response\JsonResponse;

class GetDirectionAction
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

        $data['mode'] = empty($data['mode']) ? 'walking' : $data['mode'];
        $response = $this->directionService->getDirection($data);

        return new JsonResponse($response->toArray(), 202);
    }
}
