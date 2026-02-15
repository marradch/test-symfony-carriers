<?php

namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ShippingControllerTest extends WebTestCase
{
    public function testCalculateShippingSuccess(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/shipping/calculate',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'carrier' => 'transcompany',
                'weightKg' => 12
            ])
        );

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame('transcompany', $data['carrier']);
        $this->assertSame(12, $data['weightKg']);
        $this->assertSame('EUR', $data['currency']);
        $this->assertSame(100, $data['price']);
    }

    public function testCalculateShippingUnsupportedCarrier(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/shipping/calculate',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'carrier' => 'unknown',
                'weightKg' => 5
            ])
        );

        $this->assertResponseStatusCodeSame(400);
        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('error', $data);
        $this->assertSame('Unsupported carrier', $data['error']);
    }
}
