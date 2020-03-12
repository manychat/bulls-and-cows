<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\Game;

use Src\Bc\Domain\Model\Game\Level;
use Test\Unit\AbstractBaseTest;

final class GameTest extends AbstractBaseTest
{
    public function testConstructorShouldSuccess(): void
    {
        $game = $this->getEntitiesManger()->getGame(Level::HARD);

        self::assertEquals($this->getEntitiesManger()::TEST_GAME_ID, $game->getId());
        self::assertEquals($this->getEntitiesManger()::TEST_PLAYER_ID, $game->getPlayer()->getId());
        self::assertTrue($game->getLevel()->isHard());
        self::assertEquals($this->getEntitiesManger()::TEST_FIGURES, $game->getFigures());
        self::assertEquals(0, $game->getMovesCount());
        self::assertNull($game->getResult());
    }

    public function testRemainingNumberOfMovesShouldReturnNullWhenLevelIsEasy(): void
    {
        $remainingNumberOfMoves = $this->getEntitiesManger()->getGame(Level::EASY)
            ->getRemainingNumberOfMoves($this->getEntitiesManger()->getRules());

        self::assertNull($remainingNumberOfMoves);
    }

    public function testRemainingNumberOfMovesShouldReturnNumberWhenLevelIsHard(): void
    {
        $game = $this->getEntitiesManger()->getGame(Level::HARD);
        $maxMovesCountForHardLevel = 10;
        $expectedRemainingNumberOfMoves = $maxMovesCountForHardLevel - 1;
        $rules = $this->getEntitiesManger()->getRules($maxMovesCountForHardLevel);

        $game->move();
        $remainingNumberOfMoves = $game->getRemainingNumberOfMoves($rules);

        self::assertEquals($expectedRemainingNumberOfMoves, $remainingNumberOfMoves);
    }

    public function testIsMovesLimitReachedShouldReturnFalseWhenLevelIsEasy(): void
    {
        $isMovesLimitReached = $this->getEntitiesManger()->getGame(Level::EASY)
            ->isMovesLimitReached($this->getEntitiesManger()->getRules(0));

        self::assertFalse($isMovesLimitReached);
    }

    public function testIsMovesLimitReachedShouldReturnFalseWhenLevelIsHardAndMovesRemain(): void
    {
        $isMovesLimitReached = $this->getEntitiesManger()->getGame(Level::HARD)
            ->isMovesLimitReached($this->getEntitiesManger()->getRules(10));

        self::assertFalse($isMovesLimitReached);
    }

    public function testIsMovesLimitReachedShouldReturnTrueWhenLevelIsHard(): void
    {
        $game = $this->getEntitiesManger()->getGame(Level::HARD);
        $game->move();

        $isMovesLimitReached = $game->isMovesLimitReached($this->getEntitiesManger()->getRules());

        self::assertTrue($isMovesLimitReached);
    }

    public function testFinishMoveShouldOnlyMoveWhenItIsNotVictory(): void
    {
        $game = $this->getEntitiesManger()->getGame(Level::HARD);
        $game->finishMove(false);

        self::assertEquals(1, $game->getMovesCount());
        self::assertNull($game->getResult());
    }

    public function testFinishMoveShouldMoveAndSetResultToFalseWhenItIsVictory(): void
    {
        $game = $this->getEntitiesManger()->getGame(Level::HARD);
        $game->finishMove(true);

        self::assertEquals(1, $game->getMovesCount());
        self::assertTrue($game->getResult());
    }

    public function testMoveShouldIncrement(): void
    {
        $game = $this->getEntitiesManger()->getGame(Level::HARD);
        $game->move();

        self::assertEquals(1, $game->getMovesCount());
    }

    public function testLooseShouldSetResultToFalse(): void
    {
        $game = $this->getEntitiesManger()->getGame(Level::HARD);
        $game->loose();

        self::assertFalse($game->getResult());
    }
}
