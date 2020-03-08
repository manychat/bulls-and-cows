<?php

declare(strict_types=1);

namespace Src\Http\Action;

interface FormInterface
{
    public function toArray(): array;
}
