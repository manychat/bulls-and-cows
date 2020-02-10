<?php

declare(strict_types=1);

use Src\Http\Middleware;
use Slim\App;

return function (App $app): void {
    $app->add(Middleware\ValidationExceptionMiddleware::class . '::process');
};
