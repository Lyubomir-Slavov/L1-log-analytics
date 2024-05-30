<?php
declare(strict_types=1);

namespace App\Service\API\Filter;

use App\DTO\CountApiRequest;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

final readonly class FilterBuilder
{
    /**
     * @param iterable<Filter> $filters
     */
    public function __construct(#[TaggedIterator('app.api.filters')] private iterable $filters)
    {
    }


    public function buildFilters( QueryBuilder $queryBuilder, ?CountApiRequest $request): void
    {
        if(null === $request){
            return;
        }

        foreach ($this->filters as $index => $filter){
            $filter->applyFilter($queryBuilder, $request, $index === 0);
        }
    }
}
