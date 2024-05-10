<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class ContactDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 200)]
    public string $Name = '';

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $Email = '';

    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 200)]
    public string $Message = '';

    #[Assert\NotBlank]
    public string $Service = '';
}