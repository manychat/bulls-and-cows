<?php

declare(strict_types=1);

namespace Src\Infrastructure\Framework\AppBuilder;

use Src\Http\Action;

final class RoutesBuilder extends AbstractBuilder
{
    public function build(): void
    {
        $this->getApp()->get('/', Action\HomeAction::class . '::handle');

        $this->getApp()->post('/session-start', Action\SessionStartAction::class . '::handle');

        $this->getApp()->post('/level-choose', Action\LevelChooseAction::class . '::handle');

        $this->getApp()->post('/game-move', Action\GameMoveAction::class . '::handle');

        $this->getApp()->get('/scores', Action\ScoresAction::class . '::handle');
    }
}
