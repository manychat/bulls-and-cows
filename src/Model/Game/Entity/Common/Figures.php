<?php

declare(strict_types=1);

namespace Src\Model\Game\Entity\Common;

use Src\Model\Game\Entity\Game\Result;
use Webmozart\Assert\Assert;

final class Figures
{
    public const LENGTH = 4;

    private int $figures;

    public function __construct(int $figuresRaw)
    {
        $figuresString = (string)$figuresRaw;
        $length = \count(array_unique(str_split($figuresString)));
        Assert::eq($length, self::LENGTH, 'The number must consist of 4 unique figures');
        $this->figures = $figuresRaw;
    }

    public static function generate(): self
    {
//        implode('', array_rand(range(0,9), self::LENGTH));
        $figures = [];
        while (\count($figures) < self::LENGTH) {
            $randomFigure = random_int(0, 9);
            $isFirstZero = 0 === \count($figures) && 0 === $randomFigure;
            $isAlreadyExists = \in_array($randomFigure, $figures, true);
            if ($isFirstZero || $isAlreadyExists) {
                continue;
            }
            $figures[] = $randomFigure;
        }

        $figure = (int)implode('', $figures);

        return new static($figure);
    }

    public function getFigures(): int
    {
        return $this->figures;
    }

    public function __toString(): string
    {
        return (string)$this->figures;
    }

    public function compare(Figures $figures): Result
    {
        $guess = (string)$figures;
        $answer = (string)$this;
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
