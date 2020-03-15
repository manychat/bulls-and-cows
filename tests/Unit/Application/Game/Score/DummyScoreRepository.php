<?php

declare(strict_types=1);

namespace Test\Unit\Application\Game\Score;

use Src\Bc\Domain\Model\Game\Score\ScoreRepositoryInterface;
use Test\Helper\EntitiesManger;

final class DummyScoreRepository implements ScoreRepositoryInterface
{
    private array $scores = [
        [
            'subscriberId' => EntitiesManger::TEST_SUBSCRIBER_ID,
            'name' => EntitiesManger::TEST_PLAYER_NAME,
            'score' => 1,
        ],
    ];

    public function getScore(int $subscriberId): ?array
    {
        return $this->scores[$subscriberId] ?? null;
    }

    public function getTop(): array
    {
        return $this->scores;
    }
}
