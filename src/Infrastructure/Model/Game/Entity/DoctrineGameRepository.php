<?php

declare(strict_types=1);

namespace Src\Infrastructure\Model\Game\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Src\Infrastructure\Exception\EntityNotFoundException;
use Src\Infrastructure\Model\Id\Id;
use Src\Model\Game\Entity\Game\Game;
use Src\Model\Game\Entity\Game\GameRepositoryInterface;

final class DoctrineGameRepository implements GameRepositoryInterface
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
            throw new EntityNotFoundException('Game not found.');
        }

        return $game;
    }

    public function add(Game $player): void
    {
        $this->em->persist($player);
    }
}
