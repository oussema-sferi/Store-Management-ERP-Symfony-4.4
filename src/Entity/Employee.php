<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 */
class Employee
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
    private $fullName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cin;

    /**
     * @ORM\Column(type="float")
     */
    private $salary;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity=Store::class, inversedBy="employees")
     */
    private $store;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="employee")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity=SalaryBonus::class, mappedBy="employee")
     */
    private $salaryBonuses;

    /**
     * @ORM\OneToMany(targetEntity=Attendance::class, mappedBy="employee")
     */
    private $attendances;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->salaryBonuses = new ArrayCollection();
        $this->attendances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getZone(): ?string
    {
        return $this->zone;
    }

    public function setZone(string $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

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
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setEmployee($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getEmployee() === $this) {
                $order->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SalaryBonus[]
     */
    public function getSalaryBonuses(): Collection
    {
        return $this->salaryBonuses;
    }

    public function addSalaryBonus(SalaryBonus $salaryBonus): self
    {
        if (!$this->salaryBonuses->contains($salaryBonus)) {
            $this->salaryBonuses[] = $salaryBonus;
            $salaryBonus->setEmployee($this);
        }

        return $this;
    }

    public function removeSalaryBonus(SalaryBonus $salaryBonus): self
    {
        if ($this->salaryBonuses->removeElement($salaryBonus)) {
            // set the owning side to null (unless already changed)
            if ($salaryBonus->getEmployee() === $this) {
                $salaryBonus->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Attendance[]
     */
    public function getAttendances(): Collection
    {
        return $this->attendances;
    }

    public function addAttendance(Attendance $attendance): self
    {
        if (!$this->attendances->contains($attendance)) {
            $this->attendances[] = $attendance;
            $attendance->setEmployee($this);
        }

        return $this;
    }

    public function removeAttendance(Attendance $attendance): self
    {
        if ($this->attendances->removeElement($attendance)) {
            // set the owning side to null (unless already changed)
            if ($attendance->getEmployee() === $this) {
                $attendance->setEmployee(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
       return $this->getFullName();
    }
}
