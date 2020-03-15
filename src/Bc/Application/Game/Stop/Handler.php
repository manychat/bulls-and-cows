<?php

declare(strict_types=1);

namespace Src\Bc\Application\Game\Stop;

use Src\Bc\Domain\Model\FlusherInterface;
use Src\Bc\Domain\Model\Game\GameRepositoryInterface;
use Src\Bc\Domain\Model\Player\PlayerNotFoundException;
use Src\Bc\Domain\Model\Player\PlayerRepositoryInterface;

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

    /**
     * @param Command $command
     *
     * @throws PlayerNotFoundException
     */
    public function handle(Command $command): void
    {
        $player = $this->players->getBySubscriberId($command->getSubscriberId());
        $game = $this->games->findNewByPlayerId($player->getId());

        if (null !== $game) {
            $game->loose();

            $this->flusher->flush($game);
        }
    }
}
