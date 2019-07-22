<?php

$container = require 'config/container.php';

/** @var $em \Doctrine\ORM\EntityManager */
$platform = $container->get('doctrine.entity_manager.orm_default')->getConnection()->getDatabasePlatform();
$platform->registerDoctrineTypeMapping('enum', 'string');

return new \Symfony\Component\Console\Helper\HelperSet([
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper(
        $container->get('doctrine.entity_manager.orm_default')
    ),
]);