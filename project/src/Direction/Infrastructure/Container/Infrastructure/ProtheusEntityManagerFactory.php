<?php

declare(strict_types=1);

namespace Direction\Infrastructure\Container\Infrastructure;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

final class ProtheusEntityManagerFactory
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @return mixed
     */
    public function __invoke(ContainerInterface $container): EntityManager
    {
        $appConfig = $container->get('config');

        if (!isset($appConfig['doctrine']['connection']['orm_protheus'])) {
            throw new \RuntimeException("Missing doctrine connection config for orm_default driver");
        }

        $config = new \Doctrine\ORM\Configuration;
        $config->setAutoGenerateProxyClasses(true);
        $config->setProxyDir('/tmp/Direction/data/cache');
        $config->setProxyNamespace('Direction\Domain\Entity');
        $config->setMetadataDriverImpl(
            new \Doctrine\ORM\Mapping\Driver\YamlDriver(
                array(

                )
            )
        );

        $config->setNamingStrategy(new \Doctrine\ORM\Mapping\UnderscoreNamingStrategy);
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);

        $entityManager = \Doctrine\ORM\EntityManager::create($appConfig['doctrine']['connection']['orm_protheus'], $config);

        return $entityManager;
    }
}