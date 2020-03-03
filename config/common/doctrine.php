<?php

declare(strict_types=1);

use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;
use Doctrine\DBAL;
use Src\Infrastructure\Doctrine\Type\IdType;
use Src\Infrastructure\Doctrine\Type\LevelType;
use Src\Infrastructure\Doctrine\Type\FiguresType;

return [
    EntityManagerInterface::class => function (ContainerInterface $container): EntityManager {
        $params = $container->get('config')['doctrine'];
        $config = Setup::createAnnotationMetadataConfiguration(
            $params['metadata_dirs'],
            $params['dev_mode'],
            null,
            new FilesystemCache(
                $params['cache_dir']
            ),
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
                ROOT_DIR . '/src/Model/Game/Entity',
            ],
            'connection' => [
                'url' => getenv('DB_URL'),
            ],
            'types' => [
                IdType::NAME => IdType::class,
                LevelType::NAME => LevelType::class,
                FiguresType::NAME => FiguresType::class,
            ],
        ],
    ],
];