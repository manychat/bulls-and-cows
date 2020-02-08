<?php

declare(strict_types=1);

use Src\Http\Action;
use Src\Http\Middleware\ValidationExceptionMiddleware;

return [
    ValidationExceptionMiddleware::class => function (): ValidationExceptionMiddleware {
        return new ValidationExceptionMiddleware();
    },

    Action\HomeAction::class => function (): Action\HomeAction {
        return new Action\HomeAction(
            getenv('APP_NAME')
        );
    },
];
