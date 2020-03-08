<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Src\Http\Action;
use Src\Http\Validator\Validator;
use Src\Player\Application\Register\Handler as PlayerHandler;
use Src\Game\Application\Start\Handler as GameHandler;
use Src\Game\Application\Move\Handler as MoveHandler;
use Src\Game\Application\Score\Handler as ScoreHandler;
use Src\Game\Application\Stop\Handler as StopHandler;

return [
    Action\HomeAction::class => fn() => new Action\HomeAction(getenv('APP_NAME')),

    Action\InitAction::class => fn(ContainerInterface $c) => new Action\InitAction($c->get(PlayerHandler::class)),

    Action\LevelChooseAction::class => fn(ContainerInterface $c) => new Action\LevelChooseAction(
        $c->get(GameHandler::class),
        $c->get(Validator::class),
    ),

    Action\GameMoveAction::class => fn(ContainerInterface $c) => new Action\GameMoveAction(
        $c->get(MoveHandler::class),
        $c->get(Validator::class),
    ),

    Action\ScoresAction::class => fn(ContainerInterface $c) => new Action\ScoresAction(
        $c->get(ScoreHandler::class),
        $c->get(Validator::class),
    ),

    Action\GameStopAction::class => fn(ContainerInterface $c) => new Action\GameStopAction(
        $c->get(StopHandler::class),
        $c->get(Validator::class),
    ),
];
