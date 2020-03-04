<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Framework\AppBuilder;

use DI\Bridge\Slim\Bridge;
use Slim\App;
use Src\Shared\Infrastructure\Framework\AppBuilder\EnvLoader as EnvLoader;

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
