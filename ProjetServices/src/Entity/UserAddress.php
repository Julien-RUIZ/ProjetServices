<?php

namespace App\Entity;

use App\Repository\UserAddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserAddressRepository::class)]

class UserAddress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Address = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 7, nullable: true)]
    private ?int $postalCode = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $mainAddress = false;

    #[ORM\ManyToOne(inversedBy: 'userAddresses')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $dwellingType = null;

    #[ORM\Column]
    private ?int $dwellingSize = null;

    #[ORM\Column(nullable: true)]
    private ?bool $rental = null;

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

    public function setMainAddress(?bool $mainAddress = true): static
    {
        $this->mainAddress = $mainAddress;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDwellingType(): ?string
    {
        return $this->dwellingType;
    }

    public function setDwellingType(string $dwellingType): static
    {
        $this->dwellingType = $dwellingType;

        return $this;
    }

    public function getDwellingSize(): ?int
    {
        return $this->dwellingSize;
    }

    public function setDwellingSize(int $dwellingSize): static
    {
        $this->dwellingSize = $dwellingSize;

        return $this;
    }

    public function isRental(): ?bool
    {
        return $this->rental;
    }

    public function setRental(?bool $rental): static
    {
        $this->rental = $rental;

        return $this;
    }
}
