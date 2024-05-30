<?php
declare(strict_types=1);

namespace App\Repository;

use App\DTO\CountApiRequest;
use App\Entity\LogEntry;
use App\Service\API\Filter\FilterBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<LogEntry>
 */
class LogEntryRepository extends ServiceEntityRepository
{
    public const string ALIAS = 'logEntry';
    public function __construct(ManagerRegistry $registry, private readonly FilterBuilder $apiFilterBuilder)
    {
        parent::__construct($registry, LogEntry::class);
    }

    public function save(LogEntry $logEntry, bool $flush = true): void
    {
        $this->getEntityManager()->persist($logEntry);
        if ($flush) {
            $this->flush();
        }
    }

    public function findLastImportedEntry(): ?LogEntry
    {
        return $this->createQueryBuilder(self::ALIAS)
            ->setMaxResults(1)
            ->orderBy(self::ALIAS . '.date', 'DESC')->getQuery()
            ->getOneOrNullResult();
    }


    public function getLogEntryCount(?CountApiRequest $request): int
    {
        $queryBuilder = $this->createQueryBuilder(self::ALIAS);
        $queryBuilder->select('count(1)');
        $this->apiFilterBuilder->buildFilters($queryBuilder, $request);

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
