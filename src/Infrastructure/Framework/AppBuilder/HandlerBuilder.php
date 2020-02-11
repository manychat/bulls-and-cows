<?php

declare(strict_types=1);

namespace Src\Infrastructure\Framework\AppBuilder;

use Slim\Interfaces\ErrorHandlerInterface;
use Src\Infrastructure\Exception\CommonRuntimeException;

final class HandlerBuilder extends AbstractBuilder
{
    public function build(): void
    {
        $container = $this->getApp()->getContainer();
        if (null === $container) {
            throw new CommonRuntimeException("DI doesn't set");
        }

        $config = $container->get('config')['logger'];
        $errorMiddleware = $this->getApp()->addErrorMiddleware(
            $config['displayErrorDetails'],
            $config['logErrors'],
            $config['logErrorDetails']
        );
        $handler = $container->get(ErrorHandlerInterface::class);
        $errorMiddleware->setDefaultErrorHandler($handler);
    }
}
