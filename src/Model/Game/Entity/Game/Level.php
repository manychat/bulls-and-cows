<?php

declare(strict_types=1);

namespace Src\Model\Game\Entity\Game;

use Webmozart\Assert\Assert;

final class Level
{
    public const  EASY = 'easy';
    public const  HARD = 'hard';
    private const ALL  = [self::EASY, self::HARD];

    private string $level;

    public function __construct(string $levelRaw)
    {
        $this->level = trim($levelRaw);
        Assert::oneOf($this->level, self::ALL);
    }

    public function getLevel(): string
    {
        return $this->level;
    }

    public function __toString(): string
    {
        return $this->level;
    }
}
