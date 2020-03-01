<?php

declare(strict_types=1);

namespace Src\Model\Game\UseCase\Score;

use Src\Model\Game\Entity\Score\ScoreBoard;
use Src\Model\Game\Entity\Score\ScoreRepositoryInterface;

final class Handler
{
    private ScoreRepositoryInterface $scores;

    private ScoreBoard $scoreBoard;

    public function __construct(ScoreRepositoryInterface $score, ScoreBoard $scoreBoard)
    {
        $this->scores = $score;
        $this->scoreBoard = $scoreBoard;
    }

    public function handle(Request $request): ScoreBoard
    {
        $scoresRaw = $this->scores->getTop();
        $this->scoreBoard->addRawScores($scoresRaw);

        if (
            !$this->scoreBoard->isPLayerIn($request->subscriberId) &&
            $score = $this->scores->getScore($request->subscriberId)
        ) {
            $this->scoreBoard->addRawScore($score);
        }

        return $this->scoreBoard;
    }
}
