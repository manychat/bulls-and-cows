<?php

declare(strict_types=1);

namespace Test\Unit\Application\Player\Register;

use Src\Bc\Application\Player\Register\Command;
use Src\Bc\Application\Player\Register\Handler;
use Src\Bc\Infrastructure\Domain\Model\DummyFlusher;
use Src\Bc\Infrastructure\Domain\Model\Player\MemoryPlayerRepository;
use Test\Unit\AbstractBaseTest;

final class HandlerTest extends AbstractBaseTest
{
    private Handler $handler;

    private MemoryPlayerRepository $players;

    protected function setUp(): void
    {
        parent::setUp();

        $this->players = new MemoryPlayerRepository();
        $this->handler = new Handler(
            $this->players,
            new DummyFlusher(),
        );
    }

    public function testHandleShouldSuccess(): void
    {
        $command = new Command(
            $this->getEntitiesManger()::TEST_SUBSCRIBER_ID,
            $this->getEntitiesManger()::TEST_PLAYER_NAME
        );
        $this->handler->handle($command);

        $player = $this->players->getBySubscriberId($this->getEntitiesManger()::TEST_SUBSCRIBER_ID);
        self::assertEquals($player->getName(), $this->getEntitiesManger()::TEST_PLAYER_NAME);
    }
}
