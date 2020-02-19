<?php

declare(strict_types=1);

namespace Src\Model\Game\Entity\Move;

use DateTimeImmutable;
use Src\Infrastructure\Model\Id\Id;
use Doctrine\ORM\Mapping as ORM;
use Src\Model\Game\Entity\Game\Game;
use Src\Model\Game\Entity\Number;

/**
 * @ORM\Entity
 * @ORM\Table(name="moves")
 */
final class Move
{
    /**
     * @var Id
     * @ORM\Column(type="id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var Game
     * @ORM\ManyToOne(targetEntity="Src\Model\Game\Entity\Game\Game")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $game;

    /**
     * @var Number
     * @ORM\Column(type="number")
     */
    private $number;

    /**
     * @var int
     * @ORM\Column(type="smallint", name="bulls")
     */
    private $bulls;

    /**
     * @var int
     * @ORM\Column(type="smallint", name="cows")
     */
    private $cows;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", name="create_at")
     */
    private $createdAt;

    public function __construct(Id $id, Game $game, Number $number)
    {
        $this->id = $id;
        $this->game = $game;
        $this->number = $number;
        $result = $game->getNumber()->compare($number);
        $this->bulls = $result->getBulls();
        $this->cows = $result->getCows();
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getNumber(): Number
    {
        return $this->number;
    }

    public function getBulls(): int
    {
        return $this->bulls;
    }

    public function getCows(): int
    {
        return $this->cows;
    }
}
