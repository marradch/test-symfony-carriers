<?php

namespace App\Test\Shipping;

use App\Exception\UnsupportedCarrierException;
use App\Shipping\CarrierFactory;
use App\Shipping\PackGroupCarrier;
use App\Shipping\ShippingCalculator;
use App\Shipping\TransCompanyCarrier;
use PHPUnit\Framework\TestCase;

class ShippingCalculatorTest extends TestCase
{
    private ShippingCalculator $calculator;

    protected function setUp(): void
    {
        $factory = new CarrierFactory([
            new TransCompanyCarrier(),
            new PackGroupCarrier(),
        ]);

        $this->calculator = new ShippingCalculator($factory);
    }

    public function testTransCompanyUnder10kg(): void
    {
        $price = $this->calculator->calculate('transcompany', 5);
        $this->assertEquals(20.0, $price);
    }

    public function testTransCompanyOver10kg(): void
    {
        $price = $this->calculator->calculate('transcompany', 12);
        $this->assertEquals(100.0, $price);
    }

    public function testPackGroup(): void
    {
        $price = $this->calculator->calculate('packgroup', 7);
        $this->assertEquals(7.0, $price);
    }

    public function testUnsupportedCarrier(): void
    {
        $this->expectException(UnsupportedCarrierException::class);
        $this->calculator->calculate('nonexistent', 5);
    }
}
