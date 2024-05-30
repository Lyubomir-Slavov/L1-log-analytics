<?php
namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CountApiRequest
{
    public function __construct(
        #[Assert\NotBlank(allowNull: true)]
        public array|string|null $serviceName,

        #[Assert\Range(notInRangeMessage: "Status code filter must be between {{ min }} and {{ max }}.", min: 100, max: 511)]
        public array|int|null $statusCode,

        #[Assert\DateTime]
        #[Assert\NotBlank(allowNull: true)]
        public ?string $startDate,

        #[Assert\DateTime]
        #[Assert\NotBlank(allowNull: true)]
        public ?string $endDate,
    )
    {
    }
}
