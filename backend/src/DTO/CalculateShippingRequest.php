<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CalculateShippingRequest
{
    #[Assert\NotBlank]
    public string $carrier;

    #[Assert\NotBlank]
    #[Assert\Positive]
    public int $weightKg;
}
