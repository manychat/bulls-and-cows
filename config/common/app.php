<?php

declare(strict_types=1);

use Doctrine\Common\Annotations\AnnotationRegistry;
use Src\Http\Validator\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Error\Renderers\JsonErrorRenderer;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Interfaces\ErrorHandlerInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Src\Http\Middleware\JsonBodyParserMiddleware;
use Src\Http\Middleware\ErrorsCatcherMiddleware;
use Src\Shared\Infrastructure\Framework\ErrorHandler\LogHandler;
use Slim\Error\Renderers\PlainTextErrorRenderer;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

return [
    ResponseFactoryInterface::class => fn() => new ResponseFactory(),

    JsonErrorRenderer::class => fn() => new JsonErrorRenderer(),

    PlainTextErrorRenderer::class => fn() => new PlainTextErrorRenderer(),

    ErrorHandlerInterface::class => function (ContainerInterface $c): LogHandler {
        $logHandler = new LogHandler(
            $c->get(LoggerInterface::class),
            $c->get(CallableResolverInterface::class),
            $c->get(ResponseFactoryInterface::class)
        );
        $logHandler->forceContentType('application/json');

        return $logHandler;
    },

    JsonBodyParserMiddleware::class => new JsonBodyParserMiddleware(),

    ErrorsCatcherMiddleware::class => new ErrorsCatcherMiddleware(),

    ValidatorInterface::class => function (): ValidatorInterface {
        AnnotationRegistry::registerLoader('class_exists');

        return Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
    },

    Validator::class => fn(ContainerInterface $c) => new Validator(
        $c->get(ValidatorInterface::class),
    ),
];
