<?php

declare(strict_types=1);

namespace Src\Model\Game\Entity\Game;

use Src\Model\Common\Entity\Id\Id;

interface GameRepositoryInterface
{
    public function findNewByPlayerId(Id $playerId): ?Game;

    public function getNewByPlayerId(Id $playerId): Game;

    public function add(Game $game): void;
}
