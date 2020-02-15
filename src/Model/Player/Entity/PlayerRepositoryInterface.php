<?php

declare(strict_types=1);

namespace Src\Model\Player\Entity;

interface PlayerRepositoryInterface
{
    public function findBySubscriberId(int $subscriberId): ?Player;

    public function add(Player $player): void;
}
