<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Framework\AppBuilder;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Src\Http\Action;
use Src\Http\Action\InitForm;
use Src\Http\Middleware\ValidationMiddleware as Validation;
use Src\Http\Validator\Validator;

final class RoutesBuilder extends AbstractBuilder
{
    public function build(): void
    {
        $this->getApp()->get('/', Action\HomeAction::class . '::handle');

        $this->getApp()->post('/init', Action\InitAction::class . '::handle')
            ->add(
                fn(Request $r, RequestHandler $h) => (new Validation($this->get(Validator::class), new InitForm($r)))
                    ->process($r, $h)
            );

        $this->getApp()->post('/level-choose', Action\LevelChooseAction::class . '::handle');

        $this->getApp()->post('/game-move', Action\GameMoveAction::class . '::handle');

        $this->getApp()->post('/game-stop', Action\GameStopAction::class . '::handle');

        $this->getApp()->get('/scores', Action\ScoresAction::class . '::handle');
    }
}
