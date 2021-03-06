<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\Game;

use InvalidArgumentException;
use Src\Bc\Domain\Model\Game\Level;
use Test\Unit\AbstractBaseTest;

final class LevelTest extends AbstractBaseTest
{
    public function testConstructShouldFailWhenLevelIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Level('invalid-level');
    }

    public function testConstructShouldSuccess(): void
    {
        $level = new Level(Level::EASY);

        self::assertEquals(Level::EASY, $level->getLevel());
    }

    public function testToStringShouldSuccess(): void
    {
        $level = new Level(Level::EASY);

        self::assertEquals(Level::EASY, (string)$level);
    }

    public function testIsHardShouldReturnTrueWhenItIsHard(): void
    {
        $level = new Level(Level::HARD);

        self::assertTrue($level->isHard());
    }

    public function testIsHardShouldReturnFalseWhenItIsNotHard(): void
    {
        $level = new Level(Level::EASY);

        self::assertFalse($level->isHard());
    }
}
