<?php

declare(strict_types=1);

namespace Src\Bc\Application\Game\Score;

use Src\Bc\Domain\Model\Game\Score\ScoreBoard;
use Src\Bc\Domain\Model\Game\Score\ScoreRepositoryInterface;

final class Handler
{
    private ScoreRepositoryInterface $scores;

    private ScoreBoard $scoreBoard;

    public function __construct(ScoreRepositoryInterface $score, ScoreBoard $scoreBoard)
    {
        $this->scores = $score;
        $this->scoreBoard = $scoreBoard;
    }

    public function handle(Command $request): ScoreBoard
    {
        $scoresRaw = $this->scores->getTop();
        $this->scoreBoard->addRawScores($scoresRaw);

        if (
            !$this->scoreBoard->isPLayerIn($request->getSubscriberId()) &&
            $score = $this->scores->getScore($request->getSubscriberId())
        ) {
            $this->scoreBoard->addRawScore($score);
        }

        return $this->scoreBoard;
    }
}
