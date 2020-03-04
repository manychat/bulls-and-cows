<?php

declare(strict_types=1);

namespace Src\Game\Infrastructure\Doctrine\Repository\Score;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Src\Game\Domain\Game\Game;
use Src\Game\Domain\Game\Level;
use Src\Game\Domain\Shared\RulesDto;
use Src\Game\Domain\Score\ScoreRepositoryInterface;

final class ScoreRepository implements ScoreRepositoryInterface
{
    private EntityManagerInterface $em;

    private RulesDto $rules;

    public function __construct(EntityManagerInterface $em, RulesDto $rules)
    {
        $this->em = $em;
        $this->rules = $rules;
    }

    public function getTop(): array
    {
        return $this->getBaseQuery()
            ->addOrderBy('score', 'DESC')
            ->addOrderBy('p.createdAt', 'ASC')
            ->setMaxResults($this->rules->getScoreBoardSize())
            ->getQuery()->getArrayResult();
    }

    private function getBaseQuery(): QueryBuilder
    {
        return $this->em->createQueryBuilder()
            ->select(
                'p.subscriberId',
                'p.name',
                'p.createdAt',
                '
SUM(CASE
   WHEN g.result = true AND g.level = :hard THEN :hard_victory_points
   WHEN g.result = true AND g.level = :easy THEN :easy_victory_points
   ELSE 0 END
) - SUM(CASE WHEN g.result = false THEN :easy_losing_points ELSE 0 END) score
'
            )
            ->from(Game::class, 'g')
            ->innerJoin('g.player', 'p')
            ->where('g.result IS NOT NULL')
            ->setParameters(
                [
                    ':easy' => Level::EASY,
                    ':hard' => Level::HARD,
                    ':hard_victory_points' => $this->rules->getPointsForHardVictory(),
                    ':easy_victory_points' => $this->rules->getPointsForEasyVictory(),
                    ':easy_losing_points' => $this->rules->getPointsForLosing(),
                ]
            )
            ->groupBy('p.subscriberId, p.createdAt, p.name');
    }

    public function getScore(int $subscriberId): ?array
    {
        return $this->getBaseQuery()
            ->andWhere('p.subscriberId = :subscriberId')
            ->setParameter(':subscriberId', $subscriberId)
            ->setMaxResults(1)
            ->getQuery()->getOneOrNullResult();
    }
}
