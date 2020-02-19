<?php

declare(strict_types=1);

namespace Src\Model\Game\Entity;

use Src\Model\Game\Entity\Game\Result;
use Webmozart\Assert\Assert;

final class Number
{
    private const LENGTH = 4;

    private int $number;

    public function __construct(int $numberRaw)
    {
        $numberString = (string)$numberRaw;
        $length = \count(array_unique(str_split($numberString)));
        Assert::eq($length, self::LENGTH);
        $this->number = $numberRaw;
    }

    public static function generate(): self
    {
//        implode('', array_rand(range(0,9), self::LENGTH));
        $numbers = [];
        while (\count($numbers) < self::LENGTH) {
            $randomNumber = random_int(0, 9);
            $isFirstNumberZero = 0 === \count($numbers) && 0 === $randomNumber;
            $numberAlreadyExists = \in_array($randomNumber, $numbers, true);
            if ($isFirstNumberZero || $numberAlreadyExists) {
                continue;
            }
            $numbers[] = $randomNumber;
        }

        $number = (int)implode('', $numbers);

        return new static($number);
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function __toString(): string
    {
        return (string)$this->number;
    }

    public function compare(Number $number): Result
    {
        $answer = (string)$this;
        $guess = (string)$number;
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
