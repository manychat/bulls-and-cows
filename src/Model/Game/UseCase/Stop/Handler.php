<?php

declare(strict_types=1);

namespace Src\Model\Game\UseCase\Stop;

use Src\Model\FlusherInterface;
use Src\Model\Game\Entity\Game\GameRepositoryInterface;
use Src\Model\Player\Entity\PlayerRepositoryInterface;

final class Handler
{
    private PlayerRepositoryInterface $players;

    private GameRepositoryInterface $games;

    private FlusherInterface $flusher;

    public function __construct(
        PlayerRepositoryInterface $players,
        GameRepositoryInterface $games,
        FlusherInterface $flusher
    ) {
        $this->players = $players;
        $this->games = $games;
        $this->flusher = $flusher;
    }

    public function handle(Request $request): void
    {
        $player = $this->players->getBySubscriberId($request->subscriberId);
        $game = $this->games->findNewByPlayerId($player->getId());

        if (null !== $game) {
            $game->loose();

            $this->flusher->flush($game);
        }
    }
}
