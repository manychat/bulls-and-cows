<?php

declare(strict_types=1);

namespace Src\Game\Domain\Shared;

use Src\Game\Domain\Game\Result;
use Webmozart\Assert\Assert;

final class Figures
{
    public const LENGTH = 4;

    private string $figures;

    public function __construct(string $figuresRaw)
    {
        $length = \count(array_unique(str_split($figuresRaw)));
        Assert::digits($figuresRaw, 'Only figures are allowed');
        Assert::eq($length, self::LENGTH, 'The number must consist of 4 unique figures');
        $this->figures = $figuresRaw;
    }

    public static function generate(): self
    {
        $figures = implode('', array_rand(range(0, 9), self::LENGTH));

        return new static($figures);
    }

    public function getFigures(): string
    {
        return $this->figures;
    }

    public function __toString(): string
    {
        return $this->getFigures();
    }

    public function compare(Figures $figures): Result
    {
        $guess = $figures->getFigures();
        $answer = $this->getFigures();
        $bulls = $cows = 0;

        foreach (range(0, self::LENGTH - 1) as $i) {
            if ($answer[$i] === $guess[$i]) {
                $bulls++;
            } elseif (false !== strpos($guess, $answer[$i])) {
                $cows++;
            }
        }

        return new Result($bulls, $cows);
    }
}
