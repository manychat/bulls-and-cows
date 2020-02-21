<?php

declare(strict_types=1);

namespace Src\Model\Game\Entity\Game;

final class RulesDto
{
    private int $maxMovesCountForHardLevel;

    private int $pointsForHardVictory;

    private int $pointsForHardLosing;

    private int $pointsForEasyVictory;

    private int $pointsForEasyLosing;

    public function __construct(
        int $maxMovesCountForHardLevel,
        int $pointsForHardVictory,
        int $pointsForHardLosing,
        int $pointsForEasyVictory,
        int $pointsForEasyLosing
    ) {
        $this->maxMovesCountForHardLevel = $maxMovesCountForHardLevel;
        $this->pointsForHardVictory = $pointsForHardVictory;
        $this->pointsForHardLosing = $pointsForHardLosing;
        $this->pointsForEasyVictory = $pointsForEasyVictory;
        $this->pointsForEasyLosing = $pointsForEasyLosing;
    }

    public function getMaxMovesCountForHardLevel(): int
    {
        return $this->maxMovesCountForHardLevel;
    }

    public function getPointsForHardVictory(): int
    {
        return $this->pointsForHardVictory;
    }

    public function getPointsForHardLosing(): int
    {
        return $this->pointsForHardLosing;
    }

    public function getPointsForEasyVictory(): int
    {
        return $this->pointsForEasyVictory;
    }

    public function getPointsForEasyLosing(): int
    {
        return $this->pointsForEasyLosing;
    }
}
