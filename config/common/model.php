<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Src\Infrastructure\Model\Game\Entity\DoctrineGameRepository;
use Src\Infrastructure\Model\Game\Entity\DoctrineMoveRepository;
use Src\Infrastructure\Model\Player\Entity\DoctrinePlayerRepository;
use Src\Infrastructure\Doctrine\DoctrineFlusher;
use Src\Model\FlusherInterface;
use Src\Model\Game\Entity\Game\GameRepositoryInterface;
use Src\Model\Game\Entity\Move\MoveRepositoryInterface;
use Src\Model\Player\Entity\PlayerRepositoryInterface;
use Src\Model\Player\UseCase\Register\Handler as PlayerHandler;
use Src\Model\Game\UseCase\Start\Handler as GameHandler;
use Src\Model\Game\UseCase\Move\Handler as MoveHandler;

return [
    FlusherInterface::class => function (ContainerInterface $container): FlusherInterface {
        return new DoctrineFlusher(
            $container->get(EntityManagerInterface::class)
        );
    },

    PlayerRepositoryInterface::class => function (ContainerInterface $container): PlayerRepositoryInterface {
        return new DoctrinePlayerRepository(
            $container->get(EntityManagerInterface::class),
        );
    },

    PlayerHandler::class => function (ContainerInterface $container): PlayerHandler {
        return new PlayerHandler(
            $container->get(PlayerRepositoryInterface::class),
            $container->get(FlusherInterface::class),
        );
    },

    GameRepositoryInterface::class => function (ContainerInterface $container): GameRepositoryInterface {
        return new DoctrineGameRepository(
            $container->get(EntityManagerInterface::class),
        );
    },

    GameHandler::class => function (ContainerInterface $container): GameHandler {
        return new GameHandler(
            $container->get(PlayerRepositoryInterface::class),
            $container->get(GameRepositoryInterface::class),
            $container->get(FlusherInterface::class),
        );
    },

    MoveRepositoryInterface::class => function (ContainerInterface $container): MoveRepositoryInterface {
        return new DoctrineMoveRepository(
            $container->get(EntityManagerInterface::class),
        );
    },

    MoveHandler::class => function (ContainerInterface $container): MoveHandler {
        return new MoveHandler(
            $container->get(PlayerRepositoryInterface::class),
            $container->get(GameRepositoryInterface::class),
            $container->get(MoveRepositoryInterface::class),
            $container->get(FlusherInterface::class),
        );
    },
];
