<?php

declare(strict_types=1);

namespace Test\Unit\Application\Game\Stop;

use Src\Bc\Application\Game\Stop\Command;
use Src\Bc\Application\Game\Stop\Handler;
use Src\Bc\Domain\Model\Game\Level;
use Src\Bc\Infrastructure\Domain\Model\DummyFlusher;
use Src\Bc\Infrastructure\Domain\Model\Game\MemoryGameRepository;
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
            new DummyFlusher(),
            new DummyTranslator(),
        );
    }

    public function testHandleShouldSuccess(): void
    {
        $game = $this->getEntitiesManger()->getGame(Level::EASY);
        $this->games->add($game);
        $this->players->add($game->getPlayer());

        $command = new Command($game->getPlayer()->getSubscriberId());
        $this->handler->handle($command);

        self::assertFalse($game->getResult());
    }
}
