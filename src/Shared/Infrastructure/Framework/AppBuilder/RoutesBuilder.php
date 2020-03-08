<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Framework\AppBuilder;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Src\Bc\Infrastructure\Ui\Web\Action;
use Src\Http\Middleware\ValidationMiddleware as Validation;
use Src\Http\Validator\Validator;

final class RoutesBuilder extends AbstractBuilder
{
    public function build(): void
    {
        $validator = $this->getContainer()->get(Validator::class);

        $this->getApp()->get('/', Action\Home\Action::class . '::handle');

        $this->getApp()->post('/init', Action\Init\Action::class . '::handle')
            ->add(
                fn(Request $r, Handler $h) => (new Validation($validator, new Action\Init\Form($r)))
                    ->process($r, $h)
            );

        $this->getApp()->post('/level-choose', Action\Level\Choose\Action::class . '::handle')
            ->add(
                fn(Request $r, Handler $h) => (new Validation($validator, new Action\Level\Choose\Form($r)))
                    ->process($r, $h)
            );

        $this->getApp()->post('/game-move', Action\Game\Move\Action::class . '::handle')
            ->add(
                fn(Request $r, Handler $h) => (new Validation($validator, new Action\Game\Move\Form($r)))
                    ->process($r, $h)
            );

        $this->getApp()->post('/game-stop', Action\Game\Stop\Action::class . '::handle')
            ->add(
                fn(Request $r, Handler $h) => (new Validation($validator, new Action\Game\Stop\Form($r)))
                    ->process($r, $h)
            );

        $this->getApp()->get('/scores', Action\Score\Action::class . '::handle')
            ->add(
                fn(Request $r, Handler $h) => (new Validation($validator, new Action\Score\Form($r)))
                    ->process($r, $h)
            );
    }
}
