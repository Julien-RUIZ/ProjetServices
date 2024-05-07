<?php

namespace App\Controller\Fixtures;

use App\Entity\User;
use App\Entity\UserAddress;
use App\Repository\ServiceRepository;
use App\Repository\UserAddressRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserAddressFixtureController extends AbstractController
{
    #[Route('/fixture-address', name: 'app_fixture_address')]
    public function UserAddressFixture(ServiceRepository $serviceRepository, UserAddressRepository $addressRepository, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $address = $addressRepository->findAll();
        if (!empty($address)){
            $this->addFlash('danger','Si vous souhaitez réinitialiser un jeu de fixture, merci d\'utiliser le lien : /all/fixture');
            return $this->redirectToRoute('app_home');
        }else{
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
            $service = $serviceRepository->findAll();
            foreach ($service as $value) {
                $entityManager->remove($value);
            }
            $entityManager->flush();
            return $this->redirectToRoute('app_service_fixture');
        }
    }
}