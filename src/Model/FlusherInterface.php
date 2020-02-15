<?php

declare(strict_types=1);

namespace Src\Model;

interface FlusherInterface
{
    public function flush(object ...$root): void;
}
