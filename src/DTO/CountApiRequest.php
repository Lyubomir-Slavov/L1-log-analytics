<?php
namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CountApiRequest
{
    public function __construct(
        #[Assert\NotBlank(allowNull: true)]
        public array|string|null $serviceNames,


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
