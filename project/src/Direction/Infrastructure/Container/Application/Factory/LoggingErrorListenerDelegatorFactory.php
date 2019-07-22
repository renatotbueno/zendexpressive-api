<?php

namespace Direction\Infrastructure\Container\Application\Factory;

use Direction\Application\Listener\LoggingErrorListener;
use Psr\Container\ContainerInterface;
use Zend\Stratigility\Middleware\ErrorHandler;

class LoggingErrorListenerDelegatorFactory
{
    public function __invoke(
        ContainerInterface $container,
        $serviceName,
        callable $callback
    ) : ErrorHandler {
        $listener = new LoggingErrorListener($container->get('logger'));
        $errorHandler = $callback();
        $errorHandler->attachListener($listener);
        return $errorHandler;
    }

}