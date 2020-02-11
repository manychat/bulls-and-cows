<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;
use Doctrine\DBAL;
use Src\Infrastructure\Doctrine\Type\Id\IdType;

return [
    EntityManagerInterface::class => function (ContainerInterface $container): EntityManager {
        $params = $container->get('config')['doctrine'];
        $config = Setup::createAnnotationMetadataConfiguration(
            $params['metadata_dirs'],
            $params['dev_mode'],
            null,
            null,
            false
        );

        foreach ($params['types'] as $type => $class) {
            if (!DBAL\Types\Type::hasType($type)) {
                DBAL\Types\Type::addType($type, $class);
            }
        }

        return EntityManager::create(
            $params['connection'],
            $config
        );
    },

    'config' => [
        'doctrine' => [
            'dev_mode' => false,
            'cache_dir' => ROOT_DIR . '/var/cache/doctrine',
            'metadata_dirs' => [
                ROOT_DIR . '/src/Model/Player/Entity',
            ],
            'connection' => [
                'url' => getenv('DB_URL'),
            ],
            'types' => [
                IdType::NAME => IdType::class,
            ],
        ],
    ],
];