<?php

declare(strict_types=1);

namespace Src\Game\Infrastructure\Doctrine\Repository\Game;

use Doctrine\ORM\EntityManagerInterface;
use Src\Game\Domain\Game\GameNotFoundException;
use Src\Shared\Domain\Id;
use Src\Game\Domain\Game\Game;
use Src\Game\Domain\Game\GameRepositoryInterface;

final class GameRepository implements GameRepositoryInterface
{
    private $em;

    private $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(Game::class);
    }

    public function findNewByPlayerId(Id $playerId): ?Game
    {
        /** @var Game $game */
        $game = $this->repo->findOneBy(
            [
                'player' => $playerId->getId(),
                'result' => null,
            ]
        );

        return $game;
    }

    public function getNewByPlayerId(Id $playerId): Game
    {
        $game = $this->findNewByPlayerId($playerId);
        if (null === $game) {
            throw new GameNotFoundException('Game not found.');
        }

        return $game;
    }

    public function add(Game $player): void
    {
        $this->em->persist($player);
    }
}
