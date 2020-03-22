<?php

declare(strict_types=1);

namespace Test\Unit\Application\Game\Score;

use Src\Bc\Application\Game\Score\Command;
use Src\Bc\Application\Game\Score\Handler;
use Src\Bc\Domain\Model\Game\Score\ScoreBoard;
use Test\Helper\DummyScoreRepository;
use Test\Unit\AbstractBaseTest;

final class HandlerTest extends AbstractBaseTest
{
    private Handler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new Handler(
            new DummyScoreRepository(),
            new ScoreBoard($this->getEntitiesManger()->getRules())
        );
    }

    public function testHandleShouldSuccess(): void
    {
        $command = new Command($this->getEntitiesManger()::TEST_SUBSCRIBER_ID);
        $scoreBoard = $this->handler->handle($command);

        $isPlayerInScoreBoard = strpos((string)$scoreBoard, $this->getEntitiesManger()::TEST_PLAYER_NAME) >= 0;
        self::assertTrue($isPlayerInScoreBoard);
    }
}
