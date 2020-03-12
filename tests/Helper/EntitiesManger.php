<?php

declare(strict_types=1);

namespace Test\Helper;

use Src\Bc\Domain\Model\Game\Figures;
use Src\Bc\Domain\Model\Game\Game;
use Src\Bc\Domain\Model\Game\Level;
use Src\Bc\Domain\Model\Game\RulesDto;
use Src\Bc\Domain\Model\Game\Score\Score;
use Src\Bc\Domain\Model\Id;
use Src\Bc\Domain\Model\Player\Player;

final class EntitiesManger
{
    public const TEST_GAME_ID       = 'test-game-id';
    public const TEST_PLAYER_ID     = 'test-player-id';
    public const TEST_SUBSCRIBER_ID = 1;
    public const TEST_PLAYER_NAME   = 'John Doe';
    public const TEST_FIGURES       = '0123';

    public function getPlayer(): Player
    {
        return new Player(new Id(self::TEST_PLAYER_ID), self::TEST_SUBSCRIBER_ID, self::TEST_PLAYER_NAME);
    }

    public function getGame(string $level): Game
    {
        return new Game(
            new Id(self::TEST_GAME_ID),
            $this->getPlayer(),
            new Level($level),
            $this->getFigures()
        );
    }

    public function getRules(int $maxMovesCountForHardLevel = 1): RulesDto
    {
        return new RulesDto($maxMovesCountForHardLevel, 1, 1, 1, 1);
    }

    public function getScore(int $subscriberId = self::TEST_SUBSCRIBER_ID): Score
    {
        return new Score($subscriberId, '', 0);
    }

    public function getFigures(): Figures
    {
        return new Figures(self::TEST_FIGURES);
    }
}
