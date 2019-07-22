<?php

return [
    'command_bus' => [
        'handlers' => [
            \Direction\Application\Handler\Rome2RioSaveRouteCommandHandler::class,
        ]
    ],
    'event_bus' => [
        'listeners' => [
            \Direction\Application\Listener\DirectionProcessor::class,
        ]
    ]
];