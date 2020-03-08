<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Framework\AppBuilder;

use Src\Http\Middleware;

final class MiddlewareBuilder extends AbstractBuilder
{
    public function build(): void
    {
        $this->getApp()->add(Middleware\ErrorsCatcherMiddleware::class . '::process');
        $this->getApp()->add(Middleware\JsonBodyParserMiddleware::class . '::process');
    }
}