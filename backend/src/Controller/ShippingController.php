<?php

namespace App\Controller;

use App\DTO\CalculateShippingRequest;
use App\Exception\UnsupportedCarrierException;
use App\Shipping\ShippingCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ShippingController extends AbstractController
{
    #[Route('/api/shipping/calculate', methods: ['POST'])]
    public function calculate(
        Request $request,
        ValidatorInterface $validator,
        ShippingCalculator $calculator
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $dto = new CalculateShippingRequest();
        $dto->carrier = $data['carrier'] ?? '';
        $dto->weightKg = (int) ($data['weightKg'] ?? 0);

        $errors = $validator->validate($dto);

        if (count($errors) > 0) {
            return $this->json([
                'error' => (string) $errors
            ], 400);
        }

        try {
            $price = $calculator->calculate(
                $dto->carrier,
                $dto->weightKg
            );

            return $this->json([
                'carrier' => $dto->carrier,
                'weightKg' => $dto->weightKg,
                'currency' => 'EUR',
                'price' => $price
            ]);
        } catch (UnsupportedCarrierException $e) {
            return $this->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
