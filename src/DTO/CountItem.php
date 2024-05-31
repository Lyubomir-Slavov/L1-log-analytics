<?php
declare(strict_types=1);

namespace App\DTO;

use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'CountItem')]
final readonly class CountItem
{
    public function __construct(
        #[OA\Property(title: 'count', format: 'int64')]
        public readonly int $count,
    )
    {
    }
}
