<?php

declare(strict_types=1);

namespace Src\Bc\Infrastructure\Domain\Model\Game;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Src\Bc\Domain\Model\Game\GameNotFoundException;
use Src\Shared\Domain\Id;
use Src\Bc\Domain\Model\Game\Game;
use Src\Bc\Domain\Model\Game\GameRepositoryInterface;

final class DoctrineGameRepository implements GameRepositoryInterface
{
    private EntityManagerInterface $em;

    private EntityRepository $repo;

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

    /**
     * @param Id $playerId
     *
     * @return Game
     * @throws GameNotFoundException
     */
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