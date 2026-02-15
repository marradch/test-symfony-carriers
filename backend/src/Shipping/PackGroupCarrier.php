<?php

namespace App\Shipping;

class PackGroupCarrier implements CarrierInterface
{
    public function getSlug(): string
    {
        return 'packgroup';
    }

    public function calcCost(int $kg): float
    {
        return (float) $kg;
    }
}
