<?php

declare(strict_types=1);

namespace Src\Infrastructure\Framework\AppBuilder;

use Src\Http\Action;

final class RoutesBuilder extends AbstractBuilder
{
    public function build(): void
    {
        $this->getApp()->get('/', Action\HomeAction::class . '::handle');
    }
}
