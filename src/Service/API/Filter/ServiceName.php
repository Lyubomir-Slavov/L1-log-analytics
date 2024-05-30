<?php
declare(strict_types=1);

namespace App\Service\API\Filter;

use App\DTO\CountApiRequest;
use App\Repository\LogEntryRepository;
use Doctrine\ORM\QueryBuilder;

final class ServiceName implements Filter
{
    public function applyFilter(QueryBuilder $queryBuilder, CountApiRequest $countApiRequest, bool $first): void
    {
        if(empty($countApiRequest->serviceName)){
            return;
        }

        $filterValues = \is_array($countApiRequest->serviceName) ?
            $countApiRequest->serviceName :
            [$countApiRequest->serviceName];

        $expr = $first ? 'where' : 'andWhere';
        $queryBuilder->{$expr}(LogEntryRepository::ALIAS . '.serviceName in (:serviceName)');

        $queryBuilder->setParameter('serviceName', $filterValues);
    }
}
