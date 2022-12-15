<?php

namespace App\Service\Order;

use App\Entity\Order;
use App\Entity\OrderRow;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\OrderRepository;
use App\Repository\OrderRowRepository;
use App\Service\Order\OrderSpecification\OrderRowSpecification;
use App\Service\Order\OrderSpecification\OrderSpecification;

/**
 * Service to create orders.
 */
class OrderCreator
{
    private OrderRowRepository $order_row_repository;
    private OrderRepository $order_repository;

    /**
     * @param OrderRepository $order_repository
     * @param OrderRowRepository $order_row_repository
     */
    public function __construct(OrderRepository $order_repository, OrderRowRepository $order_row_repository)
    {
        $this->order_repository = $order_repository;
        $this->order_row_repository = $order_row_repository;
    }

    /**
     * @param OrderSpecification $order_specification
     * @return Order
     */
    public function createOrder(OrderSpecification $order_specification): Order
    {
        $order = new Order();
        $order->setOrderedBy($order_specification->getOrderedBy());
        $this->order_repository->save($order, true);

        foreach ($order_specification->getOrderRows() as $order_row_specification) {
            $order_row = new OrderRow();
            $product = $order_row_specification->getProduct();
            $order_row->setProduct($product);
            $order_row->setQuantity($order_row_specification->getQuantity());
            $order_row->setPriceMinorAmount($product->getPriceMinorAmount());
            $order_row->setCurrency($product->getCurrency());
            $order_row->setParentOrder($order);
            $this->order_row_repository->save($order_row, true);
        }

        return $order;
    }
}
