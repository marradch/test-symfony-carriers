<?php

namespace App\Shipping;

use App\Exception\UnsupportedCarrierException;

class CarrierFactory
{
    private array $carriers = [];

    public function __construct(
        iterable $carriers
    ) {
        foreach ($carriers as $carrier) {
            $this->carriers[$carrier->getSlug()] = $carrier;
        }
    }

    public function get(string $slug): CarrierInterface
    {
        if (!isset($this->carriers[$slug])) {
            throw new UnsupportedCarrierException("Unsupported carrier");
        }

        return $this->carriers[$slug];
    }
}

