<?php

declare(strict_types=1);

namespace Src\Model\Game\Entity\Game;

use DateTimeImmutable;
use Src\Infrastructure\Model\Id\Id;
use Doctrine\ORM\Mapping as ORM;
use Src\Model\Game\Entity\Number;
use Src\Model\Player\Entity\Player;

/**
 * @ORM\Entity
 * @ORM\Table(name="games")
 */
final class Game
{
    /**
     * @var Id
     * @ORM\Column(type="id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var Player
     * @ORM\ManyToOne(targetEntity="Src\Model\Player\Entity\Player")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $player;

    /**
     * @var Level
     * @ORM\Column(type="level")
     */
    private $level;

    /**
     * @var Number
     * @ORM\Column(type="number")
     */
    private $number;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $result;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", name="create_at")
     */
    private $createdAt;

    public function __construct(Id $id, Player $player, Level $level, Number $number)
    {
        $this->id = $id;
        $this->player = $player;
        $this->level = $level;
        $this->number = $number;
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getLevel(): Level
    {
        return $this->level;
    }

    public function getNumber(): Number
    {
        return $this->number;
    }

    public function isResult(): bool
    {
        return $this->result;
    }
}
