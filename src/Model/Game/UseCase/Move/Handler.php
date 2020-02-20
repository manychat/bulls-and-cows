<?php

declare(strict_types=1);

namespace Src\Model\Game\UseCase\Move;

use Src\Infrastructure\Model\Id\Id;
use Src\Model\FlusherInterface;
use Src\Model\Game\Entity\Game\GameRepositoryInterface;
use Src\Model\Game\Entity\Game\Result;
use Src\Model\Game\Entity\Move\Move;
use Src\Model\Game\Entity\Move\MoveRepositoryInterface;
use Src\Model\Game\Entity\Figures;
use Src\Model\Player\Entity\PlayerRepositoryInterface;

final class Handler
{
    private PlayerRepositoryInterface $players;

    private GameRepositoryInterface $games;

    private MoveRepositoryInterface $moves;

    private FlusherInterface $flusher;

    public function __construct(
        PlayerRepositoryInterface $players,
        GameRepositoryInterface $games,
        MoveRepositoryInterface $moves,
        FlusherInterface $flusher
    ) {
        $this->players = $players;
        $this->games = $games;
        $this->moves = $moves;
        $this->flusher = $flusher;
    }

    public function handle(Request $request): Result
    {
        $player = $this->players->getBySubscriberId($request->subscriberId);
        $game = $this->games->getNewByPlayerId($player->getId());
        $move = new Move(Id::next(), $game, new Figures($request->figures));
        $result = $game->getFigures()->compare($move->getFigures());

        $this->moves->add($move);

        $this->flusher->flush($game);

        return $result;
    }
}
