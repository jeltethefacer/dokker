<?php

namespace App\Controller;

use App\Service\Order\OrderCreator;
use App\Service\Order\OrderSpecification\OrderSpecificationCreator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for the order creation
 */
class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order', methods: ['POST'])]
    public function index(Request $request, OrderCreator $order_creator, OrderSpecificationCreator $order_specification_creator): JsonResponse
    {
        $order_spec = $order_specification_creator->createFromArray(json_decode($request->getContent(), true));
        if (!$order_spec) {
            return $this->json(
                [
                    'message' => 'Error when trying to create order specification.'
                ],
            500
            );
        }

        if (!$order_creator->createOrder($order_spec)) {
            return $this->json(
                [
                    'message' => 'Something went wrong while creating the order.'
                ],
                500
            );
        }

        return $this->json([
            'status' => 'success'
        ]);
    }
}
