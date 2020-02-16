<?php

declare(strict_types=1);

namespace Src\Infrastructure\Model\Player\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Src\Infrastructure\Exception\EntityNotFoundException;
use Src\Model\Player\Entity\Player;
use Src\Model\Player\Entity\PlayerRepositoryInterface;

final class DoctrinePlayerRepository implements PlayerRepositoryInterface
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
            throw new EntityNotFoundException('Player not found.');
        }

        return $player;
    }

    public function add(Player $player): void
    {
        $this->em->persist($player);
    }
}
