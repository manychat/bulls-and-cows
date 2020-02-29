<?php

declare(strict_types=1);

namespace Src\Model\Player\UseCase\Register;

use Src\Model\Common\Entity\Id\Id;
use Src\Model\Common\FlusherInterface;
use Src\Model\Player\Entity\Player;
use Src\Model\Player\Entity\PlayerRepositoryInterface;

final class Handler
{
    private $players;

    private $flusher;

    public function __construct(PlayerRepositoryInterface $players, FlusherInterface $flusher)
    {
        $this->players = $players;
        $this->flusher = $flusher;
    }

    public function handle(Request $command): void
    {
        $player = $this->players->findBySubscriberId($command->subscriberId);

        if (null === $player) {
            $player = new Player(Id::next(), $command->subscriberId, $command->name);

            $this->players->add($player);

            $this->flusher->flush($player);
        }
    }
}
