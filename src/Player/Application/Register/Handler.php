<?php

declare(strict_types=1);

namespace Src\Player\Application\Register;

use Src\Shared\Domain\Id;
use Src\Shared\Domain\FlusherInterface;
use Src\Player\Domain\Player;
use Src\Player\Domain\PlayerRepositoryInterface;

final class Handler
{
    private $players;

    private $flusher;

    public function __construct(PlayerRepositoryInterface $players, FlusherInterface $flusher)
    {
        $this->players = $players;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $player = $this->players->findBySubscriberId($command->subscriberId);

        if (null === $player) {
            $player = new Player(Id::next(), $command->subscriberId, $command->name);

            $this->players->add($player);

            $this->flusher->flush($player);
        }
    }
}
