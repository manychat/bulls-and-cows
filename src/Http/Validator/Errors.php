<?php

declare(strict_types=1);

namespace Src\Http\Validator;

use Symfony\Component\Validator\ConstraintViolationListInterface;

final class Errors
{
    private ConstraintViolationListInterface $violations;

    public function __construct(ConstraintViolationListInterface $violations)
    {
        $this->violations = $violations;
    }

    public function __toString(): string
    {
        $rows = [];
        foreach ($this->toArray() as $field => $errors) {
            $rows[] = "{$field}: " . implode(' ', $errors);
        }

        return implode('; ', $rows);
    }

    public function toArray(): array
    {
        $errors = [];
        foreach ($this->violations as $violation) {
            $errors[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return $errors;
    }
}
