<?php

namespace App\Entity;

use App\Repository\AttendanceConfigurationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttendanceConfigurationRepository::class)
 */
class AttendanceConfiguration
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
    private $bonusAmount;

    /**
     * @ORM\Column(type="float")
     */
    private $malusAmount;

    /**
     * @ORM\Column(type="time")
     */
    private $checkInTime;

    /**
     * @ORM\Column(type="time")
     */
    private $checkOutTime;

    /**
     * @ORM\OneToOne(targetEntity=Store::class, mappedBy="attendanceConfiguration", cascade={"persist", "remove"})
     */
    private $store;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBonusAmount(): ?float
    {
        return $this->bonusAmount;
    }

    public function setBonusAmount(float $bonusAmount): self
    {
        $this->bonusAmount = $bonusAmount;

        return $this;
    }

    public function getMalusAmount(): ?float
    {
        return $this->malusAmount;
    }

    public function setMalusAmount(float $malusAmount): self
    {
        $this->malusAmount = $malusAmount;

        return $this;
    }

    public function getCheckInTime(): ?\DateTimeInterface
    {
        return $this->checkInTime;
    }

    public function setCheckInTime(\DateTimeInterface $checkInTime): self
    {
        $this->checkInTime = $checkInTime;

        return $this;
    }

    public function getCheckOutTime(): ?\DateTimeInterface
    {
        return $this->checkOutTime;
    }

    public function setCheckOutTime(\DateTimeInterface $checkOutTime): self
    {
        $this->checkOutTime = $checkOutTime;

        return $this;
    }

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        // set (or unset) the owning side of the relation if necessary
        $newAttendanceConfiguration = null === $store ? null : $this;
        if ($store->getAttendanceConfiguration() !== $newAttendanceConfiguration) {
            $store->setAttendanceConfiguration($newAttendanceConfiguration);
        }

        return $this;
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

    public function __toString(){
        // to show the name of the Category in the select
        return $this->getName();
        // to show the id of the Category in the select
        // return $this->id;
    }
}
