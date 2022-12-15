<?php

namespace App\Service\Order\OrderSpecification;

use App\Entity\OrderRow;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class OrderSpecificationCreator
{
    private UserRepository $user_repository;
    private ProductRepository $product_repository;

    /**
     * @param UserRepository $user_repository
     * @param ProductRepository $product_repository
     */
    public function __construct(UserRepository $user_repository, ProductRepository $product_repository)
    {
        $this->user_repository = $user_repository;
        $this->product_repository = $product_repository;
    }

    /**
     * @param array $request
     * @return OrderSpecification|null
     */
    public function createFromArray(array $request): ?OrderSpecification
    {
        $order_by_id = $request['user_id'] ?? null;
        if (!$order_by_id || !($ordered_by = $this->user_repository->find($order_by_id))) {
            return null;
        }

        $order_specification = new OrderSpecification($ordered_by);
        $order_rows = $request['cart_items'] ?? null;
        if (!is_array($order_rows)) {
            return null;
        }

        foreach ($order_rows as $order_row) {
            $product = $this->product_repository->find($order_row['product_id']);
            $quantity = $order_row['quantity'];
            if (!$product || !$quantity) {
                return null;
            }

            $order_row_specification = new OrderRowSpecification(
                $product,
                $quantity
            );
            $order_specification->addOrderRow($order_row_specification);
        }
        return $order_specification;
    }
}
