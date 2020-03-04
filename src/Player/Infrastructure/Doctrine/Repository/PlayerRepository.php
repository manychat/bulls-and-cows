<?php

declare(strict_types=1);

namespace Src\Player\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Src\Player\Domain\PlayerNotFoundException;
use Src\Player\Domain\Player;
use Src\Player\Domain\PlayerRepositoryInterface;

final class PlayerRepository implements PlayerRepositoryInterface
{
    private $em;

    private $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(Player::class);
    }

    public function findBySubscriberId(int $subscriberId): ?Player
    {
        /** @var Player $player */
        $player = $this->repo->findOneBy(
            [
                'subscriberId' => $subscriberId,
            ]
        );

        return $player;
    }

    public function getBySubscriberId(int $subscriberId): Player
    {
        $player = $this->findBySubscriberId($subscriberId);
        if (null === $player) {
            throw new PlayerNotFoundException('Player not found.');
        }

        return $player;
    }

    public function add(Player $player): void
    {
        $this->em->persist($player);
    }
}
