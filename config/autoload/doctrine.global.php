<?php

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => \Doctrine\DBAL\Driver\PDOMySql\Driver::class,
                'host' => 'jettyn-prod.csd9pjlleyvm.sa-east-1.rds.amazonaws.com',
                'port' => '3306',
                'user' =>'root',
                'password' => 'W3lc0m3!',
                'dbname' => 'develop',
                'charset' => 'utf8',
                'driverOptions' => [
                    1002 => "SET NAMES 'UTF8'"
                ],
            ]
        ]
    ],
];