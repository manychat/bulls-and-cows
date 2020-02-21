<?php

declare(strict_types=1);

namespace Src\Http\Middleware;

use InvalidArgumentException;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Src\Infrastructure\Exception\EntityNotFoundException;
use Src\Infrastructure\Exception\ValidationException;

final class ValidationExceptionMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (InvalidArgumentException|EntityNotFoundException $e) {
            return new JsonResponse(
                [
                    'errors' => $e->getMessage(),
                ], 400
            );
        } catch (ValidationException $e) {
            return new JsonResponse(
                [
                    'errors' => $e->getErrors()->toArray(),
                ], 400
            );
        }
    }
}
