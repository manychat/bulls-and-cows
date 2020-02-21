<?php

declare(strict_types=1);

namespace Src\Http\Action;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Src\Model\Game\UseCase\Score\Handler;

final class ScoresAction implements RequestHandlerInterface
{
    private Handler $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $scoreBoard = $this->handler->handle();

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
}
