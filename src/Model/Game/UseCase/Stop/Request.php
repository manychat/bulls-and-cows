<?php

declare(strict_types=1);

namespace Src\Model\Game\UseCase\Stop;

use Symfony\Component\Validator\Constraints as Assert;

final class Request
{
    /**
     * @var int
     * @Assert\NotBlank()
     * @Assert\Positive()
     */
    public $subscriberId;

    public function __construct(array $body)
    {
        $this->subscriberId = (int)($body['id'] ?? 0);
    }
}
