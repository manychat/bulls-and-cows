<?php

declare(strict_types=1);

namespace Src\Model\Game\Entity\Score;

final class Score
{
    private string $id;

    private string $name;

    private int $score;

    public function __construct(string $id, string $name, int $score)
    {
        $this->id = $id;
        $this->name = $name;
        $this->score = $score;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'score' => $this->score,
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}
