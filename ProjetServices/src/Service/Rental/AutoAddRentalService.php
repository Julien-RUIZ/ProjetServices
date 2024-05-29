<?php

namespace App\Service\Rental;

use App\Entity\Service;
use App\Repository\UserAddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AutoAddRentalService extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }
    public function addRental($rentalPrice, $UserAddress, $RealEstateAgency){
        $rental = new Service();
        $rental->setUserAddress($UserAddress);
        $rental->setPriceMonth($rentalPrice);
        $rental->setPriceYear($rentalPrice * 12);
        $rental->setType('Loyer');
        $rental->setName('Loyer');
        $rental->setLink($RealEstateAgency);
        $this->entityManager->persist($rental);
        $this->entityManager->flush();
    }
}