<?php

declare(strict_types=1);

namespace Src\Game\Infrastructure\Doctrine\Repository\Move;

use Doctrine\ORM\EntityManagerInterface;
use Src\Game\Domain\Move\Move;
use Src\Game\Domain\Move\MoveRepositoryInterface;

final class MoveRepository implements MoveRepositoryInterface
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
