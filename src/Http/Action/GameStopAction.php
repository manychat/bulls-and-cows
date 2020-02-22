<?php

declare(strict_types=1);

namespace Src\Http\Action;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Src\Http\Validator\Validator;
use Src\Infrastructure\Exception\ValidationException;
use Src\Model\Game\UseCase\Stop\Handler;
use Src\Model\Game\UseCase\Stop\Request;

final class GameStopAction implements RequestHandlerInterface
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
        $parsedRequest = $this->deserialize($request);

        if ($errors = $this->validator->validate($parsedRequest)) {
            throw new ValidationException($errors);
        }

        $this->handler->handle($parsedRequest);

        return new JsonResponse([]);
    }

    private function deserialize(ServerRequestInterface $request): Request
    {
        $body = $request->getParsedBody() ?? [];

        return new Request($body);
    }
}
