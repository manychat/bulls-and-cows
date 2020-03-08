<?php

declare(strict_types=1);

namespace Src\Bc\Infrastructure\Ui\Web\Action\Game\Stop;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Src\Game\Application\Stop\Handler;
use Src\Game\Application\Stop\Command;

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

        $this->handler->handle($command);

        return new JsonResponse([]);
    }
}
