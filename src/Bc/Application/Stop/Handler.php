<?php

declare(strict_types=1);

namespace Src\Bc\Application\Stop;

use Src\Shared\Domain\FlusherInterface;
use Src\Bc\Domain\Model\Game\GameRepositoryInterface;
use Src\Player\Domain\PlayerRepositoryInterface;

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

    public function handle(Command $request): void
    {
        $player = $this->players->getBySubscriberId($request->getSubscriberId());
        $game = $this->games->findNewByPlayerId($player->getId());

        if (null !== $game) {
            $game->loose();

            $this->flusher->flush($game);
        }
    }
}
