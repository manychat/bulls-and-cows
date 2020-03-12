<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Model\Game\Score;

use Test\Unit\AbstractBaseTest;

final class ScoreTest extends AbstractBaseTest
{
    public function testIsBelongsToShouldReturnTrue(): void
    {
        $isBelongsTo = $this->getEntitiesManger()->getScore()->isBelongsTo(
            $this->getEntitiesManger()::TEST_SUBSCRIBER_ID
        );

        self::assertTrue($isBelongsTo);
    }

    public function testIsBelongsToShouldReturnFalse(): void
    {
        $score = $this->getEntitiesManger()->getScore();
        $anotherSubscriberId = 2;

        self::assertFalse($score->isBelongsTo($anotherSubscriberId));
    }
}
