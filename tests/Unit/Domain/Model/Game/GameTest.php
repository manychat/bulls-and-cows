<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\Game;

use PHPUnit\Framework\TestCase;
use Src\Bc\Domain\Model\Game\Figures;
use Src\Bc\Domain\Model\Game\Game;
use Src\Bc\Domain\Model\Game\Level;
use Src\Bc\Domain\Model\Game\RulesDto;
use Src\Bc\Domain\Model\Id;
use Src\Bc\Domain\Model\Player\Player;

final class GameTest extends TestCase
{
    private const TEST_GAME_ID       = 'test-game-id';
    private const TEST_PLAYER_ID     = 'test-player-id';
    private const TEST_SUBSCRIBER_ID = 1;
    private const TEST_PLAYER_NAME   = 'John Doe';
    private const TEST_FIGURES       = '0123';

    public function testConstructorShouldSuccess(): void
    {
        $game = $this->getGame(Level::HARD);

        self::assertEquals(self::TEST_GAME_ID, $game->getId());
        self::assertEquals(self::TEST_PLAYER_ID, $game->getPlayer()->getId());
        self::assertTrue($game->getLevel()->isHard());
        self::assertEquals(self::TEST_FIGURES, $game->getFigures());
        self::assertEquals(0, $game->getMovesCount());
        self::assertNull($game->getResult());
    }

    public function testRemainingNumberOfMovesShouldReturnNullWhenLevelIsEasy(): void
    {
        $remainingNumberOfMoves = $this->getGame(Level::EASY)
            ->getRemainingNumberOfMoves($this->getRules());

        self::assertNull($remainingNumberOfMoves);
    }

    public function testRemainingNumberOfMovesShouldReturnNumberWhenLevelIsHard(): void
    {
        $game = $this->getGame(Level::HARD);
        $maxMovesCountForHardLevel = 10;
        $expectedRemainingNumberOfMoves = $maxMovesCountForHardLevel - 1;
        $rules = $this->getRules($maxMovesCountForHardLevel);

        $game->move();
        $remainingNumberOfMoves = $game->getRemainingNumberOfMoves($rules);

        self::assertEquals($expectedRemainingNumberOfMoves, $remainingNumberOfMoves);
    }

    public function testIsMovesLimitReachedShouldReturnFalseWhenLevelIsEasy(): void
    {
        $isMovesLimitReached = $this->getGame(Level::EASY)
            ->isMovesLimitReached($this->getRules(0));

        self::assertFalse($isMovesLimitReached);
    }

    public function testIsMovesLimitReachedShouldReturnFalseWhenLevelIsHardAndMovesRemain(): void
    {
        $isMovesLimitReached = $this->getGame(Level::HARD)
            ->isMovesLimitReached($this->getRules(10));

        self::assertFalse($isMovesLimitReached);
    }

    public function testIsMovesLimitReachedShouldReturnTrueWhenLevelIsHard(): void
    {
        $game = $this->getGame(Level::HARD);
        $game->move();

        $isMovesLimitReached = $game->isMovesLimitReached($this->getRules());

        self::assertTrue($isMovesLimitReached);
    }

    public function testFinishMoveShouldOnlyMoveWhenItIsNotVictory(): void
    {
        $game = $this->getGame(Level::HARD);
        $game->finishMove(false);

        self::assertEquals(1, $game->getMovesCount());
        self::assertNull($game->getResult());
    }

    public function testFinishMoveShouldMoveAndSetResultToFalseWhenItIsVictory(): void
    {
        $game = $this->getGame(Level::HARD);
        $game->finishMove(true);

        self::assertEquals(1, $game->getMovesCount());
        self::assertTrue($game->getResult());
    }

    public function testMoveShouldIncrement(): void
    {
        $game = $this->getGame(Level::HARD);
        $game->move();

        self::assertEquals(1, $game->getMovesCount());
    }

    public function testLooseShouldSetResultToFalse(): void
    {
        $game = $this->getGame(Level::HARD);
        $game->loose();

        self::assertFalse($game->getResult());
    }

    private function getPlayer(): Player
    {
        return new Player(new Id(self::TEST_PLAYER_ID), self::TEST_SUBSCRIBER_ID, self::TEST_PLAYER_NAME);
    }

    private function getGame(string $level): Game
    {
        return new Game(
            new Id(self::TEST_GAME_ID),
            $this->getPlayer(),
            new Level($level),
            new Figures(self::TEST_FIGURES)
        );
    }

    private function getRules(int $maxMovesCountForHardLevel = 1): RulesDto
    {
        return new RulesDto($maxMovesCountForHardLevel, 1, 1, 1, 1);
    }
}
