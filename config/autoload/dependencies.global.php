<?php

use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'delegators' => [
            \Zend\Stratigility\Middleware\ErrorHandler::class => [
                \Direction\Infrastructure\Container\Application\Factory\LoggingErrorListenerDelegatorFactory::class,
            ],
        ],
        'factories' => [
            // Expressive
            Zend\Expressive\Application::class => Zend\Expressive\Container\ApplicationFactory::class,
            \Zend\Expressive\Router\AuraRouter::class => \Zend\ServiceManager\Factory\InvokableFactory::class,

            'messageBuilder' => function (ContainerInterface $container) {
                $config = $container->get("config")['aws'];

                return new \Queuer\Builder\MessageBuilder(
                    \Queuer\Application\Factory\ProducerFactory::create('sqs', ['sqs' => $config['sqs']]),
                    'direction'
                );
            },

            // Doctrine
            'doctrine.entity_manager.orm_default' => \Direction\Infrastructure\Container\Infrastructure\DoctrineEntityManagerFactory::class,
            \Doctrine\ORM\Mapping\UnderscoreNamingStrategy::class => \Zend\ServiceManager\Factory\InvokableFactory::class,

            \Direction\Http\Action\Dev::class => function (ContainerInterface $container) {
                $messageBuilder = $container->get('messageBuilder');
                $config = $container->get('config');
                return new \Direction\Http\Action\Dev($messageBuilder, $config);
            },

            /**
             * Actions
             */
            \Direction\Http\Action\GetRouteAction::class => function (ContainerInterface $container) {
                $directionService = $container->get(\Direction\Application\Service\DirectionService::class);
                return new \Direction\Http\Action\GetRouteAction($directionService);
            },

            \Direction\Http\Action\GetDirectionAction::class => function (ContainerInterface $container) {
                $directionService = $container->get(\Direction\Application\Service\DirectionService::class);
                return new \Direction\Http\Action\GetDirectionAction($directionService);
            },

            \Direction\Http\Action\GetDirectionPriceAction::class => function (ContainerInterface $container) {
                $directionService = $container->get(\Direction\Application\Service\DirectionService::class);
                return new \Direction\Http\Action\GetDirectionPriceAction($directionService);
            },

            /**
             * Core Services
             */
            \Jettyn\Core\ServiceBus\CommandBusInterface::NAME => \Direction\Infrastructure\Container\Infrastructure\CommandBusFactory::class,
            \Jettyn\Core\ServiceBus\EventBusInterface::NAME => \Direction\Infrastructure\Container\Infrastructure\EventBusFactory::class,

            /**
             * Services
             */
            \Direction\Application\Service\DirectionService::class => \Direction\Infrastructure\Container\Application\Factory\DirectionServiceFactory::class,
            \Direction\Application\Service\Rome2RioService::class => \Direction\Infrastructure\Container\Application\Factory\Rome2RioServiceFactory::class,
            \Direction\Application\Service\GoogleDirectionService::class => \Direction\Infrastructure\Container\Application\Factory\GoogleDirectionServiceFactory::class,

            /**
             * Services Api
             */
            \Direction\Application\Service\PlaceApiService::class => \Direction\Infrastructure\Container\Application\Factory\PlaceApiServiceFactory::class,

            /**
             * Partners Services
             */
            \Direction\Application\Service\Partners\Rome2RioPartner::class => \Direction\Infrastructure\Container\Application\Factory\Rome2RioPartnerFactory::class,
            \Direction\Application\Service\Partners\GoogleDirectionPartner::class => \Direction\Infrastructure\Container\Application\Factory\GoogleDirectionPartnerFactory::class,

            // Handlers
            \Direction\Application\Handler\Rome2RioSaveRouteCommandHandler::class => \Direction\Infrastructure\Container\Application\Factory\Rome2RioSaveRouteCommandHandlerFactory::class,

//            \Direction\Application\Listener\DirectionProcessor::class => function (ContainerInterface $container) {
//                return new \Direction\Application\Listener\DirectionProcessor($container->get('messageBuilder'), $container->get("config"));
//            },

//
            'logger' => function (\Psr\Container\ContainerInterface $container) {

                $logger  = new \Monolog\Logger('direction');
                $handler = new \Monolog\Handler\StreamHandler('php://stdout', \Monolog\Logger::DEBUG);

                $handler->setFormatter(new \Monolog\Formatter\JsonFormatter());
                $logger->pushHandler($handler);

                $logger->pushProcessor(new \Monolog\Processor\ProcessIdProcessor());
                $logger->pushProcessor(new \Monolog\Processor\MemoryUsageProcessor());
                $logger->pushProcessor(new \Monolog\Processor\MemoryPeakUsageProcessor());

                $key = $container->get("config")['bugsnag']['key'];

                $bugsnag = Bugsnag\Client::make($key);

                $bugsnagLogger = new Bugsnag\PsrLogger\BugsnagLogger($bugsnag);
                $logger = new Bugsnag\PsrLogger\MultiLogger([$bugsnagLogger, $logger]);

                $bugsnag->getConfig()->setReleaseStage(getenv('APPLICATION_ENV'));
                $bugsnag->getConfig()->setNotifyReleaseStages($container->get("config")['bugsnag']['notify']);
                
                return $logger;
            }
        ],
        'aliases' => [
            'configuration' => 'config',
            \Zend\Expressive\Router\RouterInterface::class => \Zend\Expressive\Router\AuraRouter::class,
        ],
    ],
];
