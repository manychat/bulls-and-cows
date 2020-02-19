<?php

declare(strict_types=1);

namespace Src\Infrastructure\Model\Game\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Src\Model\Game\Entity\Move\Move;
use Src\Model\Game\Entity\Move\MoveRepositoryInterface;

final class DoctrineMoveRepository implements MoveRepositoryInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function add(Move $move): void
    {
        $this->em->persist($move);
    }
}
