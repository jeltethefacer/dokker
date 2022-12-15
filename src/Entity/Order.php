<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`orders`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $ordered_by = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'parent_order', targetEntity: OrderRow::class, orphanRemoval: true)]
    private Collection $order_rows;

    public function __construct()
    {
        $this->order_rows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderedBy(): ?User
    {
        return $this->ordered_by;
    }

    public function setOrderedBy(?User $ordered_by): self
    {
        $this->ordered_by = $ordered_by;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, OrderRow>
     */
    public function getOrderRows(): Collection
    {
        return $this->order_rows;
    }

    public function addOrderRow(OrderRow $orderRow): self
    {
        if (!$this->order_rows->contains($orderRow)) {
            $this->order_rows->add($orderRow);
            $orderRow->setParentOrder($this);
        }

        return $this;
    }

    public function removeOrderRow(OrderRow $orderRow): self
    {
        if ($this->order_rows->removeElement($orderRow)) {
            // set the owning side to null (unless already changed)
            if ($orderRow->getParentOrder() === $this) {
                $orderRow->setParentOrder(null);
            }
        }

        return $this;
    }
}
