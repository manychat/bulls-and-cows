<?php

declare(strict_types=1);

namespace Src\Model\Game\Entity;

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
        $numbers = [];
        while (\count($numbers) < self::LENGTH) {
            $randomInt = random_int(0, 9);
            if ((0 === \count($numbers) && 0 === $randomInt) || \in_array($randomInt, $numbers, true)) {
                continue;
            }
            $numbers[] = $randomInt;
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
}
