<?php

declare(strict_types=1);

namespace Src\Bc\Infrastructure\Domain\Model\Move;

use Doctrine\ORM\EntityManagerInterface;
use Src\Bc\Domain\Model\Move\Move;
use Src\Bc\Domain\Model\Move\MoveRepositoryInterface;

final class DoctrineMoveRepository implements MoveRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function add(Move $move): void
    {
        $this->em->persist($move);
    }
}
