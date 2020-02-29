<?php

declare(strict_types=1);

namespace Src\Http\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;

final class Validator
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(object $object): ?Errors
    {
        $violations = $this->validator->validate($object);
        if ($violations->count() > 0) {
            return new Errors($violations);
        }

        return null;
    }
}
