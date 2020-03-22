<?php

declare(strict_types=1);

namespace Test\Unit\Application\Game\Move;

use Src\Bc\Application\Game\Move\Command;
use Src\Bc\Application\Game\Move\Handler;
use Src\Bc\Domain\Model\Game\Level;
use Src\Bc\Infrastructure\Domain\Model\DummyFlusher;
use Src\Bc\Infrastructure\Domain\Model\Game\MemoryGameRepository;
use Src\Bc\Infrastructure\Domain\Model\Game\Move\MemoryMoveRepository;
use Src\Bc\Infrastructure\Domain\Model\Player\MemoryPlayerRepository;
use Test\Helper\DummyTranslator;
use Test\Unit\AbstractBaseTest;

final class HandlerTest extends AbstractBaseTest
{
    private Handler $handler;

    private MemoryPlayerRepository $players;

    private MemoryGameRepository $games;

    protected function setUp(): void
    {
        parent::setUp();

        $this->players = new MemoryPlayerRepository();
        $this->games = new MemoryGameRepository();
        $this->handler = new Handler(
            $this->players,
            $this->games,
            new MemoryMoveRepository(),
            new DummyFlusher(),
            $this->getEntitiesManger()->getRules(),
            new DummyTranslator(),
        );
    }

    public function testHandleShouldSuccess(): void
    {
        $player = $this->getEntitiesManger()->getPlayer();
        $this->players->add($player);

        $game = $this->getEntitiesManger()->getGame(Level::EASY);
        $this->games->add($game);

        $command = new Command($player->getSubscriberId(), (string)$game->getFigures());
        $result = $this->handler->handle($command);

        self::assertEquals(
            [
                'is_victory' => true,
                'bulls' => 4,
                'cows' => 0,
                'moves_left' => null,
            ],
            $result->toArray()
        );
    }
}
