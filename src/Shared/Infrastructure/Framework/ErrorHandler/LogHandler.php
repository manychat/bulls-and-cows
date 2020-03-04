<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Framework\ErrorHandler;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Handlers\ErrorHandler;
use Slim\Interfaces\CallableResolverInterface;

final class LogHandler extends ErrorHandler
{
    private LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger,
        CallableResolverInterface $callableResolver,
        ResponseFactoryInterface $responseFactory
    ) {
        $this->logger = $logger;
        parent::__construct($callableResolver, $responseFactory);
    }

    protected function logError(string $error): void
    {
        $this->logger->error($error);

        parent::logError($error);
    }
}
