<?php

declare(strict_types=1);

namespace Src\Model\Game\UseCase\Start;

use Src\Model\Common\Entity\Id\Id;
use Src\Model\Common\FlusherInterface;
use Src\Model\Game\Entity\Game\Game;
use Src\Model\Game\Entity\Game\GameRepositoryInterface;
use Src\Model\Game\Entity\Game\Level;
use Src\Model\Game\Entity\Common\Figures;
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

        if (null === $game) {
            $game = new Game(Id::next(), $player, new Level($request->level), Figures::generate());

            $this->games->add($game);

            $this->flusher->flush($game);
        }
    }
}
