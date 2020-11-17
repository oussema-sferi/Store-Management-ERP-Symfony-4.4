<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Store::class, inversedBy="products")
     */
    private $store;

    /**
     * @ORM\OneToMany(targetEntity=OrderList::class, mappedBy="product")
     */
    private $orderLists;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantityInStock;

    public function __construct()
    {
        $this->orderLists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
            $orderList->setProduct($this);
        }

        return $this;
    }

    public function removeOrderList(OrderList $orderList): self
    {
        if ($this->orderLists->removeElement($orderList)) {
            // set the owning side to null (unless already changed)
            if ($orderList->getProduct() === $this) {
                $orderList->setProduct(null);
            }
        }

        return $this;
    }

    public function getQuantityInStock(): ?int
    {
        return $this->quantityInStock;
    }

    public function setQuantityInStock(int $quantityInStock): self
    {
        $this->quantityInStock = $quantityInStock;

        return $this;
    }
}
