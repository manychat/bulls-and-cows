<?php

declare(strict_types=1);

namespace Src\Bc\Application\Move;

use Src\Shared\Domain\Id;
use Src\Shared\Domain\FlusherInterface;
use Src\Bc\Domain\Model\Game\GameRepositoryInterface;
use Src\Bc\Domain\Model\Game\Result;
use Src\Bc\Domain\Model\Shared\RulesDto;
use Src\Bc\Domain\Model\Move\Move;
use Src\Bc\Domain\Model\Move\MoveRepositoryInterface;
use Src\Bc\Domain\Model\Shared\Figures;
use Src\Player\Domain\PlayerRepositoryInterface;

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

    public function handle(Command $request): Result
    {
        $player = $this->players->getBySubscriberId($request->getSubscriberId());
        $game = $this->games->getNewByPlayerId($player->getId());
        $move = new Move(Id::next(), $game, new Figures($request->getFigures()));

        if ($game->isMovesLimitReached($this->rules)) {
            throw new LimitReachedException('Attempt limit reached.');
        }

        $result = $game->getFigures()->compare($move->getFigures());
        $game->finishMove($result->isVictory());

        $this->moves->add($move);
        $this->flusher->flush($move, $game);

        $result->setMovesLeft($game->getRemainingNumberOfMoves($this->rules));

        return $result;
    }
}
