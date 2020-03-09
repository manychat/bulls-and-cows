<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\Game\Score;

use PHPUnit\Framework\TestCase;
use Src\Bc\Domain\Model\Game\Score\Score;

final class ScoreTest extends TestCase
{
    private const TEST_SUBSCRIBER_ID = 1;

    public function testIsBelongsToShouldReturnTrue(): void
    {
        self::assertTrue($this->getScore(self::TEST_SUBSCRIBER_ID)->isBelongsTo(self::TEST_SUBSCRIBER_ID));
    }

    public function testIsBelongsToShouldReturnFalse(): void
    {
        $score = $this->getScore(self::TEST_SUBSCRIBER_ID);
        $anotherSubscriberId = 2;

        self::assertFalse($score->isBelongsTo($anotherSubscriberId));
    }

    private function getScore(int $subscriberId): Score
    {
        return new Score($subscriberId, '', 0);
    }
}
