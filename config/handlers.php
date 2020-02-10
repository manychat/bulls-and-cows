<?php

declare(strict_types=1);

use Slim\Interfaces\ErrorHandlerInterface;
use Slim\App;
use Src\Infrastructure\Exception\CommonRuntimeException;

return function (App $app): void {
    $container = $app->getContainer();
    if (null === $container) {
        throw new CommonRuntimeException("DI doesn't set");
    }

    $config = $container->get('config')['logger'];
    $errorMiddleware = $app->addErrorMiddleware(
        $config['displayErrorDetails'],
        $config['logErrors'],
        $config['logErrorDetails']
    );
    $handler = $container->get(ErrorHandlerInterface::class);
    $errorMiddleware->setDefaultErrorHandler($handler);
};
