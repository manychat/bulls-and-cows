<?php

declare(strict_types=1);

use Src\Http\Action;

return [
    Action\HomeAction::class => function (): Action\HomeAction {
        return new Action\HomeAction(
            getenv('APP_NAME')
        );
    },

    Action\SessionStartAction::class => function (): Action\SessionStartAction {
        return new Action\SessionStartAction();
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
