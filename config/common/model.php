<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Src\Infrastructure\Model\Player\Entity\DoctrinePlayerRepository;
use Src\Infrastructure\Doctrine\DoctrineFlusher;
use Src\Model\FlusherInterface;
use Src\Model\Player\Entity\PlayerRepositoryInterface;
use Src\Model\Player\UseCase\Register\Handler;

return [
    FlusherInterface::class => function (ContainerInterface $container): FlusherInterface {
        return new DoctrineFlusher(
            $container->get(EntityManagerInterface::class)
        );
    },

    PlayerRepositoryInterface::class => function (ContainerInterface $container): PlayerRepositoryInterface {
        return new DoctrinePlayerRepository(
            $container->get(EntityManagerInterface::class)
        );
    },

    Handler::class => function (ContainerInterface $container): Handler {
        return new Handler(
            $container->get(PlayerRepositoryInterface::class),
            $container->get(FlusherInterface::class)
        );
    },
];
