<?php

declare(strict_types=1);

namespace Src\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Src\Model\FlusherInterface;

final class DoctrineFlusher implements FlusherInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function flush(object ...$root): void
    {
        $this->em->flush();
    }
}
