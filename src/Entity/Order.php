<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    /**
     * @ORM\Column(type="float")
     */
    private $reductionRatio;

    /**
     * @ORM\Column(type="float")
     */
    private $finalTotal;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity=Store::class, inversedBy="orders")
     */
    private $store;

    /**
     * @ORM\ManyToOne(targetEntity=Employee::class, inversedBy="orders")
     */
    private $employee;

    /**
     * @ORM\OneToMany(targetEntity=OrderList::class, mappedBy="ord")
     */
    private $orderLists;

    public function __construct()
    {
        $this->orderLists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getReductionRatio(): ?float
    {
        return $this->reductionRatio;
    }

    public function setReductionRatio(float $reductionRatio): self
    {
        $this->reductionRatio = $reductionRatio;

        return $this;
    }

    public function getFinalTotal(): ?float
    {
        return $this->finalTotal;
    }

    public function setFinalTotal(float $finalTotal): self
    {
        $this->finalTotal = $finalTotal;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * @return Collection|OrderList[]
     */
    public function getOrderLists(): Collection
    {
        return $this->orderLists;
    }

    public function addOrderList(OrderList $orderList): self
    {
        if (!$this->orderLists->contains($orderList)) {
            $this->orderLists[] = $orderList;
            $orderList->setOrd($this);
        }

        return $this;
    }

    public function removeOrderList(OrderList $orderList): self
    {
        if ($this->orderLists->removeElement($orderList)) {
            // set the owning side to null (unless already changed)
            if ($orderList->getOrd() === $this) {
                $orderList->setOrd(null);
            }
        }

        return $this;
    }
}
