<?php

namespace App\Entity;

use App\Repository\UserAddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserAddressRepository::class)]

class UserAddress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private ?string $Address = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private ?string $city = null;

    #[ORM\Column(length: 7, nullable: true)]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private ?int $postalCode = null;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private ?bool $mainAddress = false;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist'], inversedBy: 'userAddresses')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private ?string $dwellingType = null;

    #[ORM\Column]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private ?int $dwellingSize = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private ?bool $rental = null;

    /**
     * @var Collection<int, Service>
     */
    #[ORM\OneToMany(targetEntity: Service::class, mappedBy: 'userAddress', cascade: ['remove', 'persist'])]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private Collection $service;

    #[ORM\Column(nullable: true)]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private ?int $number = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private ?string $additional = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private ?int $rentprice = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private ?string $RealEstateAgency = null;

    public function __construct()
    {
        $this->service = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Service>
     */
    public function getService(): Collection
    {
        return $this->service;
    }

    public function addService(Service $service): static
    {
        if (!$this->service->contains($service)) {
            $this->service->add($service);
            $service->setUserAddress($this);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        if ($this->service->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getUserAddress() === $this) {
                $service->setUserAddress(null);
            }
        }

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getAdditional(): ?string
    {
        return $this->additional;
    }

    public function setAdditional(?string $additional): static
    {
        $this->additional = $additional;

        return $this;
    }

    public function getRentprice(): ?int
    {
        return $this->rentprice;
    }

    public function setRentprice(?int $rentprice): static
    {
        $this->rentprice = $rentprice;

        return $this;
    }

    public function getRealEstateAgency(): ?string
    {
        return $this->RealEstateAgency;
    }

    public function setRealEstateAgency(?string $RealEstateAgency): static
    {
        $this->RealEstateAgency = $RealEstateAgency;

        return $this;
    }
}
