<?php

declare(strict_types=1);

namespace Src\Model\Game\Entity\Score;

interface ScoreRepositoryInterface
{
    public function getScore(int $subscriberId): ?array;

    public function getTop(): array;
}
