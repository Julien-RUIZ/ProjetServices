<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(
        min: 5,
        max: 30,
        minMessage: 'Votre titre ne peut être inférieur à {{ limit }} caractères',
        maxMessage: 'Votre titre ne peut être supérieur à {{ limit }} caractères',
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9\s]*$/",
        message: 'Please do not include any special characters',
    )]
    #[ORM\JoinColumn(nullable: true)]
    private ?string $title = null;

    #[Assert\Length(
        min: 5,
        max: 500,
        minMessage: 'Votre texte ne peut être inférieur à {{ limit }} caractères',
        maxMessage: 'Votre texte ne peut être supérieur à {{ limit }} caractères',
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9\s]*$/",
        message: 'Please do not include any special characters',
    )]
    #[ORM\Column(type: Types::TEXT)]
    #[ORM\JoinColumn(nullable: true)]
    private ?string $text = null;

    #[ORM\ManyToOne(inversedBy: 'notes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?bool $reminder = false;

    #[Assert\Date]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[Assert\Regex(pattern: '/^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9])+((\.){0,1}[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/')]
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $emailsend = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datemodif = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

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

    public function isReminder(): ?bool
    {
        return $this->reminder;
    }

    public function setReminder(bool $reminder): static
    {
        $this->reminder = $reminder;

        return $this;
    }
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }
    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getEmailsend(): ?string
    {
        return $this->emailsend;
    }

    public function setEmailsend(?string $emailsend): static
    {
        $this->emailsend = $emailsend;

        return $this;
    }

    public function getDatemodif(): ?\DateTimeInterface
    {
        return $this->datemodif;
    }

    public function setDatemodif(\DateTimeInterface $datemodif): static
    {
        $this->datemodif = $datemodif;

        return $this;
    }




}
