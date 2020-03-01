<?php

declare(strict_types=1);

namespace Src\Model\Game\UseCase\Score;

use Symfony\Component\Validator\Constraints as Assert;

final class Request
{
    /**
     * @var int
     * @Assert\NotBlank()
     * @Assert\Positive()
     */
    public $subscriberId;

    public function __construct(array $query)
    {
        $this->subscriberId = (int)($query['id'] ?? 0);
    }
}
