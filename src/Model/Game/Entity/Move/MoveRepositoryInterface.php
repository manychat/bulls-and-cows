<?php

declare(strict_types=1);

namespace Src\Model\Game\Entity\Move;

interface MoveRepositoryInterface
{
    public function add(Move $move): void;
}
