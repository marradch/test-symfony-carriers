<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CalculateShippingRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Choice(['transcompany', 'packgroup'])]
        public string $carrier,

        #[Assert\NotNull]
        #[Assert\Positive]
        public float $weightKg,
    ) {}
}
