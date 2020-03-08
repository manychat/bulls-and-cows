<?php

declare(strict_types=1);

namespace Src\Bc\Infrastructure\Ui\Web\Action\Init;

use Psr\Http\Message\ServerRequestInterface;
use Src\Bc\Infrastructure\Ui\Web\Action\FormInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class Form implements FormInterface
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
        $this->id = (int)($request->getParsedBody()['id'] ?? 0);
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
