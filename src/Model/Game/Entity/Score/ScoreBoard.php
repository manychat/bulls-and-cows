<?php

declare(strict_types=1);

namespace Src\Model\Game\Entity\Score;

final class ScoreBoard
{
    /**
     * @var Score[]
     */
    private array $scores;

    public function __construct(array $scores)
    {
        $this->scores = $scores;
    }

    public function __toString(): string
    {
        $rows = [];
        foreach ($this->scores as $index => $score) {
            $position = $index + 1;
            $rows[] = "{$position}) {$score->getName()}: {$score->getScore()}";
        }

        return implode(PHP_EOL, $rows);
    }

    public function toArray(): array
    {
        return array_map([$this, 'scoreToArray'], $this->scores);
    }

    private function scoreToArray(Score $score): array
    {
        return $score->toArray();
    }
}
