<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Src\Http\Action;
use Src\Http\Validator\Validator;
use Src\Model\Player\UseCase\Register\Handler as PlayerHandler;
use Src\Model\Game\UseCase\Start\Handler as GameHandler;

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

    Action\GameMoveAction::class => function (): Action\GameMoveAction {
        return new Action\GameMoveAction();
    },

    Action\ScoresAction::class => function (): Action\ScoresAction {
        return new Action\ScoresAction();
    },
];
