<?php

declare(strict_types=1);

namespace Src\Http\Action;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Src\Http\Validator\Validator;
use Src\Infrastructure\Exception\ValidationException;
use Src\Model\Game\UseCase\Score\Handler;
use Src\Model\Game\UseCase\Score\Request;

final class ScoresAction implements RequestHandlerInterface
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

        $scoreBoard = $this->handler->handle($parsedRequest);

        return new JsonResponse(
            [
                'version' => 'v2',
                'content' => [
                    'messages' => [
                        [
                            'type' => 'text',
                            'text' => (string)$scoreBoard,
                        ],
                    ],
                ],
            ],
        );
    }

    private function deserialize(ServerRequestInterface $request): Request
    {
        $query = $request->getQueryParams() ?? [];

        return new Request($query);
    }
}
