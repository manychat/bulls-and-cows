<?php

declare(strict_types=1);

namespace Src\Model\Player\Entity;

use DateTimeImmutable;
use Src\Infrastructure\Model\Id\Id;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="players", indexes={
 *     @ORM\Index(name="players_subscriber_id_idx", columns={"subscriber_id"}),
 * })
 */
final class Player
{
    /**
     * @var Id
     * @ORM\Column(type="id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", name="subscriber_id")
     */
    private $subscriberId;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", name="create_at")
     */
    private $createdAt;

    public function __construct(Id $id, string $subscriberId, string $name)
    {
        $this->id = $id;
        $this->subscriberId = $subscriberId;
        $this->name = $name;
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getSubscriberId(): string
    {
        return $this->subscriberId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
