<?php

namespace Direction\Http\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Direction\Application\Service\DirectionService;
use Zend\Diactoros\Response\JsonResponse;

class GetRouteAction
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
        try {

            $data = json_decode($request->getBody()->getContents(), true);
            $response = $this->directionService->getRoutes($data);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
	    
        /**
         * 1. Servico pra buscar do banco as rotas da rom2rio
         */
        return new JsonResponse($response->toArray(), 202);
    }
}
