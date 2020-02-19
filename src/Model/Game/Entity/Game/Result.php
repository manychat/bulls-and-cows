<?php

declare(strict_types=1);

namespace Src\Model\Game\Entity\Game;

final class Result
{
    private int $bulls;

    private int $cows;

    public function __construct(int $bulls, int $cows)
    {
        $this->bulls = $bulls;
        $this->cows = $cows;
    }

    public function getBulls(): int
    {
        return $this->bulls;
    }

    public function getCows(): int
    {
        return $this->cows;
    }

    public function toArray(): array
    {
        return [
            'bulls' => $this->getBulls(),
            'cows' => $this->getCows(),
        ];
    }
}
