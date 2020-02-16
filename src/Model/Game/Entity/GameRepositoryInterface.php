<?php

declare(strict_types=1);

namespace Src\Model\Game\Entity;

use Src\Infrastructure\Model\Id\Id;

interface GameRepositoryInterface
{
    public function findNewByPlayerId(Id $playerId): ?Game;

    public function add(Game $game): void;
}
