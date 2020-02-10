<?php

declare(strict_types=1);

use Src\Http\Action;
use Slim\App;

return function (App $app): void {
    $app->get('/', Action\HomeAction::class . '::handle');
};
