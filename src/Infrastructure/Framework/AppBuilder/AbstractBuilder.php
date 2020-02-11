<?php

declare(strict_types=1);

namespace Src\Infrastructure\Framework\AppBuilder;

use Slim\App;

abstract class AbstractBuilder
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    protected function getApp(): App
    {
        return $this->app;
    }

    abstract public function build(): void;
}
