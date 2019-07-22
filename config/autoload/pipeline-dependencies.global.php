<?php

use Zend\Expressive\Container\ErrorHandlerFactory;
use Zend\Expressive\Container\ErrorResponseGeneratorFactory;
use Zend\Expressive\Container\NotFoundDelegateFactory;
use Zend\Expressive\Container\NotFoundHandlerFactory;
use Zend\Expressive\Delegate\NotFoundDelegate;
use Zend\Expressive\Middleware\ErrorResponseGenerator;
use Zend\Expressive\Middleware\ImplicitHeadMiddleware;
use Zend\Expressive\Middleware\ImplicitOptionsMiddleware;
use Zend\Expressive\Middleware\NotFoundHandler;
use Zend\Stratigility\Middleware\ErrorHandler;
use Zend\Stratigility\Middleware\OriginalMessages;

return [
    'dependencies' => [
        'aliases' => [
            'Zend\Expressive\Delegate\DefaultDelegate' => NotFoundDelegate::class,
        ],
        'invokables' => [
            ImplicitHeadMiddleware::class => ImplicitHeadMiddleware::class,
            ImplicitOptionsMiddleware::class => ImplicitOptionsMiddleware::class,
            OriginalMessages::class => OriginalMessages::class,
        ],
        'factories' => [
            ErrorHandler::class => ErrorHandlerFactory::class,
            ErrorResponseGenerator::class => ErrorResponseGeneratorFactory::class,
            NotFoundDelegate::class => NotFoundDelegateFactory::class,
            NotFoundHandler::class => NotFoundHandlerFactory::class,
        ],
    ],
];
