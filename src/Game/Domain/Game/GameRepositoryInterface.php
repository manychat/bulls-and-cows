<?php

declare(strict_types=1);

namespace Src\Game\Domain\Game;

use Src\Shared\Domain\Id;

interface GameRepositoryInterface
{
    public function findNewByPlayerId(Id $playerId): ?Game;

    /**
     * @param Id $playerId
     * @throws GameNotFoundException
     *
     * @return Game
     */
    public function getNewByPlayerId(Id $playerId): Game;

    public function add(Game $game): void;
}
