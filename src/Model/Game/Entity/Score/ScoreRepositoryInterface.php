<?php

declare(strict_types=1);

namespace Src\Model\Game\Entity\Score;

interface ScoreRepositoryInterface
{
    public function getTop(): ScoreBoard;
}
