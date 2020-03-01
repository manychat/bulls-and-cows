<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Src\Http\Action;
use Src\Http\Validator\Validator;
use Src\Model\Player\UseCase\Register\Handler as PlayerHandler;
use Src\Model\Game\UseCase\Start\Handler as GameHandler;
use Src\Model\Game\UseCase\Move\Handler as MoveHandler;
use Src\Model\Game\UseCase\Score\Handler as ScoreHandler;
use Src\Model\Game\UseCase\Stop\Handler as StopHandler;

return [
    Action\HomeAction::class => function (): Action\HomeAction {
        return new Action\HomeAction(
            getenv('APP_NAME')
        );
    },

    Action\InitAction::class => function (ContainerInterface $container): Action\InitAction {
        return new Action\InitAction(
            $container->get(PlayerHandler::class),
            $container->get(Validator::class),
        );
    },

    Action\LevelChooseAction::class => function (ContainerInterface $container): Action\LevelChooseAction {
        return new Action\LevelChooseAction(
            $container->get(GameHandler::class),
            $container->get(Validator::class),
        );
    },

    Action\GameMoveAction::class => function (ContainerInterface $container): Action\GameMoveAction {
        return new Action\GameMoveAction(
            $container->get(MoveHandler::class),
            $container->get(Validator::class),
        );
    },

    Action\ScoresAction::class => function (ContainerInterface $container): Action\ScoresAction {
        return new Action\ScoresAction(
            $container->get(ScoreHandler::class),
            $container->get(Validator::class),
        );
    },

    Action\GameStopAction::class => function (ContainerInterface $container): Action\GameStopAction {
        return new Action\GameStopAction(
            $container->get(StopHandler::class),
            $container->get(Validator::class),
        );
    },
];
