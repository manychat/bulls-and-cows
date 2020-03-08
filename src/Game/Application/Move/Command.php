<?php

declare(strict_types=1);

namespace Src\Game\Application\Move;

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
     */
    public $figures;

    public function __construct(array $body)
    {
        $this->subscriberId = (int)($body['id'] ?? 0);
        $this->figures = (string)($body['figures'] ?? '');
    }
}