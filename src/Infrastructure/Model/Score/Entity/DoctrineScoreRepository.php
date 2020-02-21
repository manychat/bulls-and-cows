<?php

declare(strict_types=1);

namespace Src\Infrastructure\Model\Score\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Src\Model\Game\Entity\Score\Score;
use Src\Model\Game\Entity\Score\ScoreBoard;
use Src\Model\Game\Entity\Score\ScoreRepositoryInterface;

final class DoctrineScoreRepository implements ScoreRepositoryInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getTop(): ScoreBoard
    {
        $sql = <<<SQL
SELECT p.id,
       p.name,
       SUM(CASE
               WHEN g.result = true AND g.level = 'hard' THEN 3
               WHEN g.result = true AND g.level = 'easy' THEN 2
               ELSE 0 END
           ) - SUM(CASE WHEN g.result = false THEN 1 ELSE 0 END) score
FROM games g
         RIGHT JOIN players p ON p.id = g.player_id
WHERE g.result IS NOT NULL
GROUP BY p.id, p.name
ORDER BY score DESC
LIMIT 10;
SQL;

        $statement = $this->em->getConnection()->prepare($sql);
        $statement->execute();

        $rows = [];
        while ($row = $statement->fetch()) {
            $rows[] = new Score($row['id'], $row['name'], $row['score']);
        }

        return new ScoreBoard($rows);
    }
}
