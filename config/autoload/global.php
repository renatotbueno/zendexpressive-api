<?php

return [
    'debug' => true,
    'config_cache_enabled' => false,
    'aws' => [
        'sqs' => [
            'host' => getenv('AWS_SQS_HOST'),
            'version' => getenv('AWS_SQS_VERSION'),
            'region' => getenv('AWS_SQS_REGION'),
            'key' => getenv('AWS_SQS_KEY'),
            'secret' => getenv('AWS_SQS_SECRET'),
        ]
    ],
    'bugsnag' => [
        'key' => getenv('BUGSNAG_KEY'),
        'notify' => ['prod', 'dev']
    ],
    'sqs_queue_prefix' => getenv('APP_SQS_QUEUE_PREFIX'),
    'endpoint_service_place' => getenv('ENDPOINT_SERVICE_PLACE'),
    'place_api_service' => [
        'host' => getenv('HOST_SERVICE_PLACE'),
        'endpoint_get_city' => env('ENDPOINT_PLACE_GET_CITY'),
        'endpoint_city_by_geocoding' => env('ENDPOINT_PLACE_GET_CITY_BY_GEOCODING')
    ],
];
