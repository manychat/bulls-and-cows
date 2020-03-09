<?php

declare(strict_types=1);

namespace Test\Unit\Application\Game\Move;

use PHPUnit\Framework\TestCase;
use Src\Bc\Application\Game\Move\Command;
use Src\Bc\Application\Game\Move\Handler as MoveHandler;
use Src\Bc\Domain\Model\Game\Figures;
use Src\Bc\Domain\Model\Game\Game;
use Src\Bc\Domain\Model\Game\Level;
use Src\Bc\Domain\Model\Game\RulesDto;
use Src\Bc\Domain\Model\Id;
use Src\Bc\Domain\Model\Player\Player;
use Src\Bc\Infrastructure\Domain\Model\DummyFlusher;
use Src\Bc\Infrastructure\Domain\Model\Game\MemoryGameRepository;
use Src\Bc\Infrastructure\Domain\Model\Game\Move\MemoryMoveRepository;
use Src\Bc\Infrastructure\Domain\Model\Player\MemoryPlayerRepository;

final class HandlerTest extends TestCase
{
    private MoveHandler $handler;

    private MemoryPlayerRepository $players;

    private MemoryGameRepository $games;

    private MemoryMoveRepository $moves;

    private const TEST_GAME_ID       = 'test-game-id';
    private const TEST_PLAYER_ID     = 'test-player-id';
    private const TEST_SUBSCRIBER_ID = 1;
    private const TEST_PLAYER_NAME   = 'John Doe';
    private const TEST_FIGURES       = '0123';

    protected function setUp(): void
    {
        parent::setUp();
        $this->players = new MemoryPlayerRepository();

        $this->games = new MemoryGameRepository();
        $this->moves = new MemoryMoveRepository();
        $this->handler = new MoveHandler(
            $this->players,
            $this->games,
            $this->moves,
            new DummyFlusher(),
            new RulesDto(1, 1, 1, 1, 1)
        );
    }

    public function testHandleShouldSuccess(): void
    {
        $player = new Player(new Id(self::TEST_PLAYER_ID), self::TEST_SUBSCRIBER_ID, self::TEST_PLAYER_NAME);
        $this->players->add($player);

        $game = new Game(
            new Id(self::TEST_GAME_ID),
            $player,
            new Level(Level::EASY),
            new Figures(self::TEST_FIGURES)
        );
        $this->games->add($game);

        $command = new Command(self::TEST_SUBSCRIBER_ID, self::TEST_FIGURES);
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
