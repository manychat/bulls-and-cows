<?php

declare(strict_types=1);

namespace Src\Game\Application\Start;

use InvalidArgumentException;
use Src\Shared\Domain\Id;
use Src\Shared\Domain\FlusherInterface;
use Src\Game\Domain\Game\Game;
use Src\Game\Domain\Game\GameRepositoryInterface;
use Src\Game\Domain\Game\Level;
use Src\Game\Domain\Shared\Figures;
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

        if (null === $game) {
            try {
                $game = new Game(Id::next(), $player, new Level($request->getLevel()), Figures::generate());

                $this->games->add($game);

                $this->flusher->flush($game);
            } catch (InvalidArgumentException $e) {
                throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
            }
        }
    }
}
