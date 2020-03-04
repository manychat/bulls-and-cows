<?php

declare(strict_types=1);

namespace Src\Shared\Domain;

interface FlusherInterface
{
    public function flush(object ...$root): void;
}
