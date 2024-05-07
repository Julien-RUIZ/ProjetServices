<?php

namespace App\Controller\Fixtures;

use App\Repository\ServiceRepository;
use App\Repository\UserAddressRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Attribute\Route;

class AllFixtureController extends AbstractController
{
    #[Route('/all/fixture', name: 'app_all_fixture')]
    public function index(UserRepository $userRepository,
                          EntityManagerInterface $entityManager,
                          UserAddressRepository $addressRepository,
                          ServiceRepository $serviceRepository
                                                        ): Response
    {
        $user = $userRepository->findAll();
        $address = $addressRepository->findAll();
        $service = $serviceRepository->findAll();
        if (!empty($user)){
            foreach ($user as $value){
                $entityManager->remove($value);
            }
        }if (!empty($address)){
            foreach ($address as $value){
                $entityManager->remove($value);
            }
        }if (!empty($service)) {
            foreach ($service as $value) {
                $entityManager->remove($value);
            }
        }
        $entityManager->flush();
        $session = new Session();
        $session->invalidate();


        return $this->redirectToRoute('app_fixture');


    }
}
