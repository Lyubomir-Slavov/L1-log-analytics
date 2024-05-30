<?php
declare(strict_types=1);

namespace App\Service\API\Filter;

use App\DTO\CountApiRequest;
use App\Repository\LogEntryRepository;
use Doctrine\ORM\QueryBuilder;

final class StartDate implements Filter
{

    public function applyFilter(QueryBuilder $queryBuilder, CountApiRequest $countApiRequest, bool $first): void
    {
        if(empty($countApiRequest->startDate)){
            return;
        }

        $expr = $first ? 'where' : 'andWhere';
        $queryBuilder->{$expr}(LogEntryRepository::ALIAS . '.startDate >= :startDate');

        $queryBuilder->setParameter('startDate', $countApiRequest->startDate);
    }
}
