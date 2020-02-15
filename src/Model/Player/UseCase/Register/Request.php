<?php

declare(strict_types=1);

namespace Src\Model\Player\UseCase\Register;

use Symfony\Component\Validator\Constraints as Assert;

final class Request
{
    /**
     * @Assert\NotBlank()
     * @Assert\Positive()
     * @var int
     */
    public $subscriberId;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @var string
     */
    public $name;

    public function __construct(array $body)
    {
        $this->subscriberId = $body['id'] ?? '';
        $this->name = $body['name'] ?? '';
    }
}
