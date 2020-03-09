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
    FlusherInterface::class => fn(ContainerInterface $c) => new DoctrineFlusher(
        $c->get(EntityManagerInterface::class),
    ),

    PlayerRepositoryInterface::class => fn(ContainerInterface $c) => new PlayerRepository(
        $c->get(EntityManagerInterface::class),
    ),

    PlayerHandler::class => fn(ContainerInterface $c) => new PlayerHandler(
        $c->get(PlayerRepositoryInterface::class),
        $c->get(FlusherInterface::class),
    ),

    GameRepositoryInterface::class => fn(ContainerInterface $c) => new GameRepository(
        $c->get(EntityManagerInterface::class),
    ),

    GameHandler::class => fn(ContainerInterface $c) => new GameHandler(
        $c->get(PlayerRepositoryInterface::class),
        $c->get(GameRepositoryInterface::class),
        $c->get(FlusherInterface::class),
    ),

    MoveRepositoryInterface::class => fn(ContainerInterface $c) => new MoveRepository(
        $c->get(EntityManagerInterface::class),
    ),

    RulesDto::class => fn(ContainerInterface $container) => new RulesDto(
        $container->get('config')['game']['rules']['max_moves_count_for_hard_level'],
        $container->get('config')['game']['rules']['points_for_hard_victory'],
        $container->get('config')['game']['rules']['points_for_easy_victory'],
        $container->get('config')['game']['rules']['points_for_losing'],
        $container->get('config')['game']['rules']['score_board_size'],
    ),

    MoveHandler::class => fn(ContainerInterface $c) => new MoveHandler(
        $c->get(PlayerRepositoryInterface::class),
        $c->get(GameRepositoryInterface::class),
        $c->get(MoveRepositoryInterface::class),
        $c->get(FlusherInterface::class),
        $c->get(RulesDto::class),
    ),

    ScoreRepositoryInterface::class => fn(ContainerInterface $c) => new ScoreRepository(
        $c->get(EntityManagerInterface::class),
        $c->get(RulesDto::class),
    ),

    ScoreHandler::class => fn(ContainerInterface $c) => new ScoreHandler(
        $c->get(ScoreRepositoryInterface::class),
        $c->get(ScoreBoard::class),
    ),

    StopHandler::class => fn(ContainerInterface $c) => new StopHandler(
        $c->get(PlayerRepositoryInterface::class),
        $c->get(GameRepositoryInterface::class),
        $c->get(FlusherInterface::class),
    ),

    ScoreBoard::class => fn(ContainerInterface $c) => new ScoreBoard(
        $c->get(RulesDto::class),
    ),

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
