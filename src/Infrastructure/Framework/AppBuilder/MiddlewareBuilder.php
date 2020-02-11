<?php

declare(strict_types=1);

namespace Src\Infrastructure\Framework\AppBuilder;

use Src\Http\Middleware;

final class MiddlewareBuilder extends AbstractBuilder
{
    public function build(): void
    {
        $this->getApp()->add(Middleware\ValidationExceptionMiddleware::class . '::process');
    }
}
