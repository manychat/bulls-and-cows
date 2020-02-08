<?php

declare(strict_types=1);

namespace Src\Infrastructure\Exception;

use \LogicException;

final class ValidationException extends LogicException
{
    private array $errors;

    public function __construct(array $errors, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct('Validation errors.', $code, $previous);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
