<?php

declare(strict_types=1);

namespace Src\Infrastructure\Framework\AppBuilder;

use DI\Bridge\Slim\Bridge;
use Slim\App;
use Src\Infrastructure\Environment\Loader as EnvLoader;

final class ApiDirector
{
    public static function build(): App
    {
        (new EnvLoader())->load();

        $container = ContainerBuilder::build();
        $app = Bridge::create($container);

        (new MiddlewareBuilder($app))->build();
        (new HandlerBuilder($app))->build();
        (new RoutesBuilder($app))->build();

        return $app;
    }
}
