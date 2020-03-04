<?php

declare(strict_types=1);

namespace Src\Http\Action;

use Src\Http\Validator\Validator;
use Src\Http\Middleware\ValidationException;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Src\Player\Application\Register\Command;
use Src\Player\Application\Register\Handler;

final class InitAction implements RequestHandlerInterface
{
    private Handler $handler;

    private Validator $validator;

    public function __construct(Handler $handler, Validator $validator)
    {
        $this->handler = $handler;
        $this->validator = $validator;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parsedRequest = $this->parseCommand($request);

        if ($errors = $this->validator->validate($parsedRequest)) {
            throw new ValidationException($errors);
        }

        $this->handler->handle($parsedRequest);

        return new JsonResponse([]);
    }

    private function parseCommand(ServerRequestInterface $request): Command
    {
        $body = $request->getParsedBody() ?? [];

        return new Command($body);
    }
}
