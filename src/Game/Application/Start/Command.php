<?php

declare(strict_types=1);

namespace Src\Game\Application\Start;

final class Command
{
    private $subscriberId;

    private $level;

    public function __construct(int $subscriberId, string $level)
    {
        $this->subscriberId = $subscriberId;
        $this->level = $level;
    }

    public function getSubscriberId(): int
    {
        return $this->subscriberId;
    }

    public function getLevel(): string
    {
        return $this->level;
    }
}
