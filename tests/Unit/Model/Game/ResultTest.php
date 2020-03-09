<?php

declare(strict_types=1);

namespace Test\Unit\Model\Game;

use PHPUnit\Framework\TestCase;
use Src\Bc\Domain\Model\Game\Result;

final class ResultTest extends TestCase
{
    public function testIsVictoryShouldReturnTrueWhenFourBulls(): void
    {
        $result = new Result(4, 0);

        self::assertTrue($result->isVictory());
    }

    public function testIsVictoryShouldReturnFalseWhenNotFourBulls(): void
    {
        $result = new Result(3, 0);

        self::assertFalse($result->isVictory());
    }

    public function testToArray(): void
    {
        $bulls = 1;
        $cows = 2;
        $result = new Result($bulls, $cows);
        $movesLeft = 2;
        $result->setMovesLeft($movesLeft);

        self::assertEquals(
            [
                'is_victory' => false,
                'bulls' => $bulls,
                'cows' => $cows,
                'moves_left' => $movesLeft,
            ],
            $result->toArray()
        );
    }
}
