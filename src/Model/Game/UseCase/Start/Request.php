<?php

declare(strict_types=1);

namespace Src\Model\Game\UseCase\Start;

use Symfony\Component\Validator\Constraints as Assert;

final class Request
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
    public $level;

    public function __construct(array $body)
    {
        $this->subscriberId = (int)($body['id'] ?? 0);
        $this->level = $body['level'] ?? '';
    }
}
