<?php
declare(strict_types=1);

namespace App\Service\API\Filter;

use App\DTO\CountApiRequest;
use App\Repository\LogEntryRepository;
use Doctrine\ORM\QueryBuilder;

final class StatusCode implements Filter
{

    public function applyFilter(QueryBuilder $queryBuilder, CountApiRequest $countApiRequest, bool $first): void
    {
        if(empty($countApiRequest->statusCode)){
            return;
        }

        $filterValues = \is_array($countApiRequest->statusCode) ?
            $countApiRequest->statusCode :
            [$countApiRequest->statusCode];

        $expr = $first ? 'where' : 'andWhere';
        $queryBuilder->{$expr}(LogEntryRepository::ALIAS . '.statusCode in (:statusCode)');

        $queryBuilder->setParameter('statusCode', $filterValues);
    }
}
