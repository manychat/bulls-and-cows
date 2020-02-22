<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Src\Infrastructure\Model\Game\Entity\DoctrineGameRepository;
use Src\Infrastructure\Model\Game\Entity\DoctrineMoveRepository;
use Src\Infrastructure\Model\Player\Entity\DoctrinePlayerRepository;
use Src\Infrastructure\Doctrine\DoctrineFlusher;
use Src\Infrastructure\Model\Score\Entity\DoctrineScoreRepository;
use Src\Model\FlusherInterface;
use Src\Model\Game\Entity\Game\GameRepositoryInterface;
use Src\Model\Game\Entity\Game\RulesDto;
use Src\Model\Game\Entity\Move\MoveRepositoryInterface;
use Src\Model\Game\Entity\Score\ScoreRepositoryInterface;
use Src\Model\Player\Entity\PlayerRepositoryInterface;
use Src\Model\Player\UseCase\Register\Handler as PlayerHandler;
use Src\Model\Game\UseCase\Start\Handler as GameHandler;
use Src\Model\Game\UseCase\Move\Handler as MoveHandler;
use Src\Model\Game\UseCase\Score\Handler as ScoreHandler;
use Src\Model\Game\UseCase\Stop\Handler as StopHandler;

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

    RulesDto::class => function (ContainerInterface $container): RulesDto {
        $config = $container->get('config')['game']['rules'];

        return new RulesDto(
            $config['max_moves_count_for_hard_level'],
            $config['points_for_hard_victory'],
            $config['points_for_hard_losing'],
            $config['points_for_easy_victory'],
            $config['points_for_easy_losing'],
        );
    },

    MoveHandler::class => function (ContainerInterface $container): MoveHandler {
        return new MoveHandler(
            $container->get(PlayerRepositoryInterface::class),
            $container->get(GameRepositoryInterface::class),
            $container->get(MoveRepositoryInterface::class),
            $container->get(FlusherInterface::class),
            $container->get(RulesDto::class),
        );
    },

    ScoreRepositoryInterface::class => function (ContainerInterface $container): ScoreRepositoryInterface {
        return new DoctrineScoreRepository($container->get(EntityManagerInterface::class),);
    },

    ScoreHandler::class => function (ContainerInterface $container): ScoreHandler {
        return new ScoreHandler(
            $container->get(ScoreRepositoryInterface::class),
        );
    },

    StopHandler::class => function (ContainerInterface $container): StopHandler {
        return new StopHandler(
            $container->get(PlayerRepositoryInterface::class),
            $container->get(GameRepositoryInterface::class),
            $container->get(FlusherInterface::class),
        );
    },

    'config' => [
        'game' => [
            'rules' => [
                'max_moves_count_for_hard_level' => 10,
                'points_for_hard_victory' => 3,
                'points_for_hard_losing' => 1,
                'points_for_easy_victory' => 2,
                'points_for_easy_losing' => 1,
            ],
        ],
    ],
];
