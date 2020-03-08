<?php

declare(strict_types=1);

namespace Src\Http\Action;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class InitForm implements FormInterface
{
    /**
     * @var int
     * @Assert\NotBlank()
     * @Assert\Type("int")
     * @Assert\Positive()
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $name;

    public function __construct(ServerRequestInterface $request)
    {
        $this->id = $request->getParsedBody()['id'] ?? null;
        $this->name = $request->getParsedBody()['name'] ?? null;
    }

    public function toArray(): array
    {
        return [
            'subscriberId' => $this->id,
            'name' => $this->name,
        ];
    }
}
