<?php

namespace App\Shipping;

interface CarrierInterface
{
    public function getSlug(): string;

    public function calcCost(int $kg): float;
}
