<?php

declare(strict_types=1);

namespace Src\Model\Game\UseCase\Move;

use Src\Infrastructure\Exception\LimitReachedException;
use Src\Infrastructure\Model\Id\Id;
use Src\Model\FlusherInterface;
use Src\Model\Game\Entity\Game\GameRepositoryInterface;
use Src\Model\Game\Entity\Game\Result;
use Src\Model\Game\Entity\Game\RulesDto;
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

    private RulesDto $rules;

    public function __construct(
        PlayerRepositoryInterface $players,
        GameRepositoryInterface $games,
        MoveRepositoryInterface $moves,
        FlusherInterface $flusher,
        RulesDto $rules
    ) {
        $this->players = $players;
        $this->games = $games;
        $this->moves = $moves;
        $this->flusher = $flusher;
        $this->rules = $rules;
    }

    public function handle(Request $request): Result
    {
        $player = $this->players->getBySubscriberId($request->subscriberId);
        $game = $this->games->getNewByPlayerId($player->getId());
        $move = new Move(Id::next(), $game, new Figures($request->figures));

        if ($game->isMovesLimitReached($this->rules)) {
            throw new LimitReachedException('Attempt limit reached.');
        }

        $result = $game->getFigures()->compare($move->getFigures());
        $game->finishMove($result->isVictory());
        $result->setMovesLeft($game->getRemainingNumberOfMoves($this->rules));

        $this->moves->add($move);

        $this->flusher->flush($move, $game);

        return $result;
    }
}
