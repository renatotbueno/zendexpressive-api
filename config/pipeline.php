<?php

return function(\Zend\Expressive\Application $app): void {

//    $app->pipe(new Tuupola\Middleware\JwtAuthentication([
//        'secure' => false,
//        'relaxed' => [],
//        'secret' => getenv('JWT_SECRET')
//    ]));

    $app->pipe(\Jettyn\Core\Factory\RequestIdMiddlewareFactory::create());

    $app->pipe(\Zend\Stratigility\Middleware\OriginalMessages::class);
    $app->pipe(\Zend\Stratigility\Middleware\ErrorHandler::class);

    $app->pipeRoutingMiddleware();

    $app->pipe(\Zend\Expressive\Middleware\ImplicitHeadMiddleware::class);
    $app->pipe(\Zend\Expressive\Middleware\ImplicitOptionsMiddleware::class);

    $app->pipeDispatchMiddleware();

    $app->pipe(\Zend\Expressive\Middleware\NotFoundHandler::class);
};
