<?php

declare(strict_types=1);

namespace Src\Http\Middleware;

use Src\Http\Validator\Errors;
use Src\Shared\Domain\CommonRuntimeException;

final class ValidationException extends CommonRuntimeException
{
    private Errors $errors;

    public function __construct(Errors $errors, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct('Validation errors.', $code, $previous);
        $this->errors = $errors;
    }

    public function getErrors(): Errors
    {
        return $this->errors;
    }
}
