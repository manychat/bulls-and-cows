<?php

declare(strict_types=1);

use DI\Bridge\Slim\Bridge;
use Src\Infrastructure\Environment\Loader as EnvLoader;

!defined('ROOT_DIR') && define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/vendor/autoload.php';

// include environment
(new EnvLoader())->load();

// run application
(function (): void {
    $container = require ROOT_DIR . '/config/container.php';
    $app = Bridge::create($container);
    (require ROOT_DIR . '/config/middlewares.php')($app);
    (require ROOT_DIR . '/config/handlers.php')($app);
    (require ROOT_DIR . '/config/routes.php')($app);
    $app->run();
})();
