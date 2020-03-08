<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Src\Player\Application\Register\Handler as PlayerHandler;
use Src\Game\Application\Start\Handler as GameHandler;
use Src\Game\Application\Move\Handler as MoveHandler;
use Src\Game\Application\Score\Handler as ScoreHandler;
use Src\Game\Application\Stop\Handler as StopHandler;
use Src\Bc\Infrastructure\Ui\Web\Action;

return [
    Action\Home\Action::class => fn() => new Action\Home\Action(getenv('APP_NAME')),

    Action\Init\Action::class => fn(ContainerInterface $c) => new Action\Init\Action(
        $c->get(PlayerHandler::class),
    ),

    Action\Level\Choose\Action::class => fn(ContainerInterface $c) => new Action\Level\Choose\Action(
        $c->get(GameHandler::class),
    ),

    Action\Game\Move\Action::class => fn(ContainerInterface $c) => new Action\Game\Move\Action(
        $c->get(MoveHandler::class),
    ),

    Action\Game\Stop\Action::class => fn(ContainerInterface $c) => new Action\Game\Stop\Action(
        $c->get(StopHandler::class),
    ),

    Action\Score\Action::class => fn(ContainerInterface $c) => new Action\Score\Action(
        $c->get(ScoreHandler::class),
    ),
];
