<?php

namespace App\Shipping;

class TransCompanyCarrier implements CarrierInterface
{
    public function getSlug(): string
    {
        return 'transcompany';
    }

    public function calcCost(int $kg): float
    {
        return $kg <= 10 ? 20.0 : 100.0;
    }
}
