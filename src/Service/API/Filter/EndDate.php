<?php
declare(strict_types=1);

namespace App\Service\API\Filter;

use App\DTO\CountApiRequest;
use App\Repository\LogEntryRepository;
use Doctrine\ORM\QueryBuilder;

final class EndDate implements Filter
{

    public function applyFilter(QueryBuilder $queryBuilder, CountApiRequest $countApiRequest, bool $first): void
    {
        if(empty($countApiRequest->endDate)){
            return;
        }
        $expr = $first ? 'where' : 'andWhere';
        $queryBuilder->{$expr}(LogEntryRepository::ALIAS . '.endDate <= :endDate');

        $queryBuilder->setParameter('endDate', $countApiRequest->endDate);
    }
}
