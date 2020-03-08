<?php

declare(strict_types=1);

namespace Src\Game\Application\Score;

final class Command
{
    private $subscriberId;

    public function __construct(int $subscriberId)
    {
        $this->subscriberId = $subscriberId;
    }

    public function getSubscriberId(): int
    {
        return $this->subscriberId;
    }
}
