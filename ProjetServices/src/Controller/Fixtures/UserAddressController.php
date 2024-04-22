<?php

namespace App\Controller\Fixtures;

use App\Entity\User;
use App\Entity\UserAddress;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserAddressController extends AbstractController
{
    #[Route('/fixture-address', name: 'app_fixture_address')]
    public function UserAddressFixture( EntityManagerInterface $entityManager): Response
    {
        for ($i=0; $i<10; $i++){
            $userAddress = new UserAddress();
            $userAddress->setAddress('rue inconnu '.$i)
                ->setMainAddress(False)
                ->setCity('Ville'.$i)
                ->setRental(rand(0,1))
                ->setPostalCode(rand(0, 99000))
                ->setDwellingSize(rand(0, 300))
                ->setDwellingType('Appartement');
            $entityManager->persist($userAddress);
        }
        $entityManager->flush();
        return $this->redirectToRoute('app_home');
    }
}