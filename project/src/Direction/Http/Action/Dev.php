<?php

namespace Direction\Http\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Queuer\Builder\MessageBuilder;
use Zend\Diactoros\Response\JsonResponse;

class Dev implements MiddlewareInterface
{
    /** @var MessageBuilder $messageBuilder */
    private $messageBuilder;

    private $config;

    public function __construct(MessageBuilder $messageBuilder, $config){
        $this->messageBuilder = $messageBuilder;
        $this->config = $config;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $token = $request->getQueryParams()['token'];

        if ($token != '0732b7702d5d08466fe3606226ae28bb') {
            return new JsonResponse('Unauthorized', 401);
        }

        exit(phpinfo());
    }
}
