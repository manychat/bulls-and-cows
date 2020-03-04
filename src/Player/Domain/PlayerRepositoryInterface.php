<?php

declare(strict_types=1);

namespace Src\Player\Domain;

interface PlayerRepositoryInterface
{
    public function findBySubscriberId(int $subscriberId): ?Player;

    /**
     * @param int $subscriberId
     * @throws PlayerNotFoundException
     *
     * @return Player
     */
    public function getBySubscriberId(int $subscriberId): Player;

    public function add(Player $player): void;
}
