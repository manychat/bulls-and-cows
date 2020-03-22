<?php

declare(strict_types=1);

namespace Test\Unit\Application\Game\Start;

use Src\Bc\Application\Game\Start\Command;
use Src\Bc\Application\Game\Start\Handler;
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
        $player = $this->getEntitiesManger()->getPlayer();
        $this->players->add($player);

        $command = new Command($player->getSubscriberId(), Level::EASY);
        $this->handler->handle($command);

        $game = $this->games->getNewByPlayerId($player->getId());
        self::assertNotNull($game);
    }
}
