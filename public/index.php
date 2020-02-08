<?php

declare(strict_types=1);

use Src\Infrastructure\Environment\Loader as EnvLoader;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

!defined('ROOT_DIR') && define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/vendor/autoload.php';

// include environment
(new EnvLoader)->load();

// run application
(function (): void {
    $app = AppFactory::create();
    $app->get(
        '/',
        function (Request $request, Response $response, $args) {
            $response->getBody()->write('Hello world!');

            return $response;
        }
    );

    $app->run();
})();
