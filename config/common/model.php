<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Src\Game\Infrastructure\Doctrine\Repository\Game\GameRepository;
use Src\Game\Infrastructure\Doctrine\Repository\Move\MoveRepository;
use Src\Player\Infrastructure\Doctrine\Repository\PlayerRepository;
use Src\Shared\Infrastructure\Doctrine\DoctrineFlusher;
use Src\Game\Infrastructure\Doctrine\Repository\Score\ScoreRepository;
use Src\Shared\Domain\FlusherInterface;
use Src\Game\Domain\Game\GameRepositoryInterface;
use Src\Game\Domain\Shared\RulesDto;
use Src\Game\Domain\Move\MoveRepositoryInterface;
use Src\Game\Domain\Score\ScoreBoard;
use Src\Game\Domain\Score\ScoreRepositoryInterface;
use Src\Player\Domain\PlayerRepositoryInterface;
use Src\Player\Application\Register\Handler as PlayerHandler;
use Src\Game\Application\Start\Handler as GameHandler;
use Src\Game\Application\Move\Handler as MoveHandler;
use Src\Game\Application\Score\Handler as ScoreHandler;
use Src\Game\Application\Stop\Handler as StopHandler;

return [
    FlusherInterface::class => function (ContainerInterface $container): FlusherInterface {
        return new DoctrineFlusher(
            $container->get(EntityManagerInterface::class)
        );
    },

    PlayerRepositoryInterface::class => function (ContainerInterface $container): PlayerRepositoryInterface {
        return new PlayerRepository(
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
        return new GameRepository(
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
        return new MoveRepository(
            $container->get(EntityManagerInterface::class),
        );
    },

    RulesDto::class => function (ContainerInterface $container): RulesDto {
        $config = $container->get('config')['game']['rules'];

        return new RulesDto(
            $config['max_moves_count_for_hard_level'],
            $config['points_for_hard_victory'],
            $config['points_for_easy_victory'],
            $config['points_for_losing'],
            $config['score_board_size'],
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
        return new ScoreRepository(
            $container->get(EntityManagerInterface::class),
            $container->get(RulesDto::class),
        );
    },

    ScoreHandler::class => function (ContainerInterface $container): ScoreHandler {
        return new ScoreHandler(
            $container->get(ScoreRepositoryInterface::class),
            $container->get(ScoreBoard::class),
        );
    },

    StopHandler::class => function (ContainerInterface $container): StopHandler {
        return new StopHandler(
            $container->get(PlayerRepositoryInterface::class),
            $container->get(GameRepositoryInterface::class),
            $container->get(FlusherInterface::class),
        );
    },

    ScoreBoard::class => function (ContainerInterface $container): ScoreBoard {
        return new ScoreBoard(
            $container->get(RulesDto::class),
        );
    },

    'config' => [
        'game' => [
            'rules' => [
                'max_moves_count_for_hard_level' => 10,
                'points_for_hard_victory' => 3,
                'points_for_easy_victory' => 2,
                'points_for_losing' => 1,
                'score_board_size' => 10,
            ],
        ],
    ],
];
