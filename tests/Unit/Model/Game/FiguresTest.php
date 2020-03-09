<?php

declare(strict_types=1);

namespace Test\Unit\Model\Game;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Src\Bc\Domain\Model\Game\Figures;

final class FiguresTest extends TestCase
{
    public function testConstructShouldFailWhenFiguresAreNotNumbers(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Figures('not-a-number');
    }

    public function testConstructShouldFailWhenFiguresAreNotUnique(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Figures('0122');
    }

    public function testConstructShouldFailWhenNotFourFigures(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Figures('01234');
    }

    public function testConstructShouldSuccess(): void
    {
        $figuresRaw = '0123';
        $figures = new Figures($figuresRaw);

        self::assertEquals($figuresRaw, $figures->getFigures());
    }

    public function testGenerateShouldSuccess(): void
    {
        self::assertInstanceOf(Figures::class, Figures::generate());
    }

    public function testToStringShouldSuccess(): void
    {
        $figuresRaw = '0123';
        $figures = new Figures($figuresRaw);

        self::assertEquals($figuresRaw, (string)$figures);
    }

    public function testCompareShouldReturnVictoryWhenFourBulls(): void
    {
        $figures1 = Figures::generate();
        $figures2 = clone $figures1;

        $result = $figures1->compare($figures2);

        self::assertTrue($result->isVictory());
    }

    public function testCompareShouldReturnTwoBullsAndOneCow(): void
    {
        $figures1 = new Figures('0123');
        $figures2 = new Figures('0134');

        $result = $figures1->compare($figures2);

        self::assertEquals(2, $result->getBulls());
        self::assertEquals(1, $result->getCows());
        self::assertFalse($result->isVictory());
    }
}
