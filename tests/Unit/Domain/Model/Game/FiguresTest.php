<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\Game;

use InvalidArgumentException;
use Src\Bc\Domain\Model\Game\Figures;
use Test\Unit\AbstractBaseTest;

final class FiguresTest extends AbstractBaseTest
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
        $figuresRaw = $this->getEntitiesManger()::TEST_FIGURES;
        $figures = new Figures($figuresRaw);

        self::assertEquals($figuresRaw, $figures->getFigures());
    }

    public function testGenerateShouldSuccess(): void
    {
        self::assertInstanceOf(Figures::class, Figures::generate());
    }

    public function testToStringShouldSuccess(): void
    {
        $figuresRaw = $this->getEntitiesManger()::TEST_FIGURES;
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
        $figures1 = $this->getEntitiesManger()->getFigures();
        $figures2 = new Figures('0134');

        $result = $figures1->compare($figures2);

        self::assertEquals(2, $result->getBulls());
        self::assertEquals(1, $result->getCows());
        self::assertFalse($result->isVictory());
    }
}
