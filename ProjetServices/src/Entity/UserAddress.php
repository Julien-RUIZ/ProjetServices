<?php

namespace App\Entity;

use App\Repository\UserAdressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserAdressRepository::class)]
class UserAddress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?int $postalCode = null;

    #[ORM\Column(nullable: true)]
    private ?bool $mainAddress = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(?string $Address): static
    {
        $this->Address = $Address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(?int $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function isMainAddress(): ?bool
    {
        return $this->mainAddress;
    }

    public function setMainAddress(?bool $mainAddress): static
    {
        $this->mainAddress = $mainAddress;

        return $this;
    }
}