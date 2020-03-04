<?php

declare(strict_types=1);

namespace Src\Game\Domain\Move;

interface MoveRepositoryInterface
{
    public function add(Move $move): void;
}
