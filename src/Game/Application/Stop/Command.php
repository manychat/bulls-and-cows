<?php

declare(strict_types=1);

namespace Src\Game\Application\Stop;

use Symfony\Component\Validator\Constraints as Assert;

final class Command
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
