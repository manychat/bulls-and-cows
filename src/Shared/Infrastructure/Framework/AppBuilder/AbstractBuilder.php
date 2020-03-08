<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Framework\AppBuilder;

use Psr\Container\ContainerInterface;
use RuntimeException;
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

    protected function getContainer(): ContainerInterface
    {
        $container = $this->getApp()->getContainer();

        if (null === $container) {
            throw new RuntimeException("DI doesn't set");
        }

        return $container;
    }

    abstract public function build(): void;
}
