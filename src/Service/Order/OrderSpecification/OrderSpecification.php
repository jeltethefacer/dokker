<?php

namespace App\Service\Order\OrderSpecification;

use App\Entity\OrderRow;
use App\Entity\User;

/**
 *
 */
class OrderSpecification
{
    private User $ordered_by;
    /**
     * @var OrderRowSpecification[]
     */
    private array $order_rows = [];

    /**
     * @param User $ordered_by
     */
    public function __construct(
        User $ordered_by
    ) {
        $this->ordered_by = $ordered_by;
    }

    /**
     * @return User
     */
    public function getOrderedBy(): User
    {
        return $this->ordered_by;
    }

    /**
     * @param User $ordered_by
     */
    public function setOrderedByUserId(User $ordered_by): void
    {
        $this->ordered_by = $ordered_by;
    }

    /**
     * @param OrderRowSpecification $order_row
     * @return $this
     */
    public function addOrderRow(OrderRowSpecification $order_row): self
    {
        $this->order_rows[] = $order_row;
        return $this;
    }

    /**
     * @return OrderRowSpecification[]
     */
    public function getOrderRows(): array
    {
        return $this->order_rows;
    }
}
