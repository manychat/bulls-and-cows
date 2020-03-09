<?php

declare(strict_types=1);

namespace Src\Bc\Infrastructure\Ui\Web\Action\Score;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Src\Bc\Application\Score\Handler;
use Src\Bc\Application\Score\Command;

final class Action implements RequestHandlerInterface
{
    private Handler $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $command = new Command($request->getAttribute('subscriberId'));

        $scoreBoard = $this->handler->handle($command);

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
