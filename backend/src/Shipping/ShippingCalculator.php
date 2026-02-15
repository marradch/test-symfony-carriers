<?php

namespace App\Shipping;

class ShippingCalculator
{
    public function __construct(
        private CarrierFactory $carrierFactory
    ) {
    }

    public function calculate(string $carrierSlug, int $kg): float
    {
        $carrier = $this->carrierFactory->get($carrierSlug);

        return $carrier->calcCost($kg);
    }
}
