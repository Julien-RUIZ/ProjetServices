<?php

namespace App\Controller\Services;

use App\Repository\UserAddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServiceManagementController extends AbstractController
{
    #[Route('/services', name: 'app_service_management')]
    public function index(UserAddressRepository $addressRepository): Response
    {

        $userId = $this->getUser()->getId();
        $address = $addressRepository->findByUserId($userId);
        //dd($address);


        return $this->render('service_management/index.html.twig', [
            'controller_name' => 'ServiceManagementController', 'address'=>$address
        ]);
    }
}
