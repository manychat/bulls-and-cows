<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Error\Renderers\JsonErrorRenderer;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Interfaces\ErrorHandlerInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Src\Http\Middleware\JsonBodyParserMiddleware;
use Src\Http\Middleware\ValidationExceptionMiddleware;
use Src\Infrastructure\Framework\ErrorHandler\LogHandler;
use Slim\Error\Renderers\PlainTextErrorRenderer;

return [
    ResponseFactoryInterface::class => function () {
        return new ResponseFactory();
    },

    JsonErrorRenderer::class => function () {
        return new JsonErrorRenderer();
    },

    PlainTextErrorRenderer::class => function () {
        return new PlainTextErrorRenderer();
    },

    ErrorHandlerInterface::class => function (ContainerInterface $container): ErrorHandlerInterface {
        return $container->get(LogHandler::class);
    },

    LogHandler::class => function (ContainerInterface $container): LogHandler {
        $logHandler = new LogHandler(
            $container->get(LoggerInterface::class),
            $container->get(CallableResolverInterface::class),
            $container->get(ResponseFactoryInterface::class)
        );
        $logHandler->forceContentType('application/json');

        return $logHandler;
    },

    ValidationExceptionMiddleware::class => function (): ValidationExceptionMiddleware {
        return new ValidationExceptionMiddleware();
    },

    JsonBodyParserMiddleware::class => function (): JsonBodyParserMiddleware {
        return new JsonBodyParserMiddleware();
    },
];
