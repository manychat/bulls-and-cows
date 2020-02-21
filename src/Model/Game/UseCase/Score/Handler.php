<?php

declare(strict_types=1);

namespace Src\Model\Game\UseCase\Score;

use Src\Model\Game\Entity\Score\ScoreBoard;
use Src\Model\Game\Entity\Score\ScoreRepositoryInterface;

final class Handler
{
    private ScoreRepositoryInterface $scores;

    public function __construct(ScoreRepositoryInterface $score)
    {
        $this->scores = $score;
    }

    public function handle(): ScoreBoard
    {
        return $this->scores->getTop();
    }
}
