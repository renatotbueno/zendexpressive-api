<?php

declare(strict_types=1);

namespace Direction\Infrastructure\Container\Infrastructure;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Jettyn\Core\Infrastructure\Types\UuidType;

final class DoctrineEntityManagerFactory
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

        if (!isset($appConfig['doctrine']['connection']['orm_default'])) {
            throw new \RuntimeException("Missing doctrine connection config for orm_default driver");
        }

        $config = new \Doctrine\ORM\Configuration;
        $config->setAutoGenerateProxyClasses(true);
        $config->setProxyDir('/tmp/Direction/data/cache');
        $config->setProxyNamespace('Direction\Domain\Entity');
        $config->setMetadataDriverImpl(
            new \Doctrine\ORM\Mapping\Driver\YamlDriver(
                array(
                    __DIR__ . '/../../Persistence/Doctrine/ORM'
                )
            )
        );

        if (!Type::hasType(UuidType::class)) {
            Type::addType(UuidType::class, UuidType::class);
        }

        $config->setNamingStrategy(new \Doctrine\ORM\Mapping\UnderscoreNamingStrategy);
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);

        $entityManager = \Doctrine\ORM\EntityManager::create($appConfig['doctrine']['connection']['orm_default'], $config);

        return $entityManager;
    }
}