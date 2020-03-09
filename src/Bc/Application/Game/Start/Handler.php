<?php

declare(strict_types=1);

namespace Src\Bc\Application\Game\Start;

use Exception;
use InvalidArgumentException;
use Src\Bc\Application\RuntimeException;
use Src\Bc\Domain\Model\Id;
use Src\Bc\Domain\Model\FlusherInterface;
use Src\Bc\Domain\Model\Game\Game;
use Src\Bc\Domain\Model\Game\GameRepositoryInterface;
use Src\Bc\Domain\Model\Game\Level;
use Src\Bc\Domain\Model\Game\Figures;
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
     * @param Command $request
     *
     * @throws Exception
     * @throws PlayerNotFoundException
     * @throws RuntimeException
     */
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