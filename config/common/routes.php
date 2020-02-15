<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Src\Http\Action;
use Src\Model\Player\UseCase\Register\Handler;

return [
    Action\HomeAction::class => function (): Action\HomeAction {
        return new Action\HomeAction(
            getenv('APP_NAME')
        );
    },

    Action\InitAction::class => function (ContainerInterface $container): Action\InitAction {
        return new Action\InitAction(
            $container->get(Handler::class),
        );
    },

    Action\LevelChooseAction::class => function (): Action\LevelChooseAction {
        return new Action\LevelChooseAction();
    },

    Action\GameMoveAction::class => function (): Action\GameMoveAction {
        return new Action\GameMoveAction();
    },

    Action\ScoresAction::class => function (): Action\ScoresAction {
        return new Action\ScoresAction();
    },
];
