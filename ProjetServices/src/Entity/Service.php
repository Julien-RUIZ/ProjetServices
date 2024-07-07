<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]

class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private ?string $link = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private ?int $priceMonth = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private ?int $priceYear = null;

    #[ORM\Column(length: 255)]
    #[Groups(['jsondataextract', 'jsondataInteg'])]
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: UserAddress::class, inversedBy: 'service')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserAddress $userAddress = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getPriceMonth(): ?int
    {
        return $this->priceMonth;
    }

    public function setPriceMonth(?int $priceMonth): static
    {
        $this->priceMonth = $priceMonth;

        return $this;
    }

    public function getPriceYear(): ?int
    {
        return $this->priceYear;
    }

    public function setPriceYear(?int $priceYear): static
    {
        $this->priceYear = $priceYear;

        return $this;
    }

    public function getUserAddress(): ?UserAddress
    {
        return $this->userAddress;
    }

    public function setUserAddress(?UserAddress $userAddress): static
    {
        $this->userAddress = $userAddress;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }
}
