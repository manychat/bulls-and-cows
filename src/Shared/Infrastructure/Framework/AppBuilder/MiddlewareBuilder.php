<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Framework\AppBuilder;

use Src\Http\Middleware;

final class MiddlewareBuilder extends AbstractBuilder
{
    public function build(): void
    {
        $this->getApp()->add(\Src\Bc\Infrastructure\Ui\Web\Middleware\ErrorsCatcherMiddleware::class . '::process');
        $this->getApp()->add(\Src\Bc\Infrastructure\Ui\Web\Middleware\JsonBodyParserMiddleware::class . '::process');
    }
}
