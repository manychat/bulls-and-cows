<?php

declare(strict_types=1);

namespace Src\Player\Application\Register;

use Symfony\Component\Validator\Constraints as Assert;

final class Command
{
    /**
     * @var int
     * @Assert\NotBlank()
     * @Assert\Positive()
     */
    public $subscriberId;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    public $name;

    public function __construct(array $body)
    {
        $this->subscriberId = (int)($body['id'] ?? 0);
        $this->name = (string)($body['name'] ?? '');
    }
}
