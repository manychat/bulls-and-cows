<?php

declare(strict_types=1);

namespace Src\Player\Application\Register;

final class Command
{
    private $subscriberId;

    private $name;

    public function __construct(int $subscriberId, string $name)
    {
        $this->subscriberId = $subscriberId;
        $this->name = $name;
    }

    public function getSubscriberId(): int
    {
        return $this->subscriberId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
