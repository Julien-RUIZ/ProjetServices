<?php

namespace App\Controller\Fixtures;

use App\Entity\User;
use App\Entity\UserAddress;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserAddressFixtureController extends AbstractController
{
    #[Route('/fixture-address', name: 'app_fixture_address')]
    public function UserAddressFixture( EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $user = $userRepository->findAll();
        for ($i=0; $i<10; $i++){
            $userAddress = new UserAddress();
            if ($i === 0){
                $userAddress->setMainAddress(True);
            }
            $userAddress->setAddress('rue inconnu '.$i)
                ->setCity('Ville'.$i)
                ->setNumber(rand(null, 100))
                ->setUser($user[$i])
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