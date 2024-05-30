<?php
declare(strict_types=1);

namespace App\Service\API\Filter;

use App\DTO\CountApiRequest;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.api.filters')]
interface Filter
{
    public function applyFilter(QueryBuilder $queryBuilder, CountApiRequest $countApiRequest, bool $first): void;
}
