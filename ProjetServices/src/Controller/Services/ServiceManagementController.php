<?php

namespace App\Controller\Services;
use App\Repository\UserAddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServiceManagementController extends AbstractController
{
    #[Route('/services', name: 'app_service_management')]
    public function display(UserAddressRepository $addressRepository): Response
    {
        if ($this->getUser()){
            $userId = $this->getUser()->getId();
            $address = $addressRepository->findAddressAndServiceByUserid($userId);
            return $this->render('/Service/service_management/index.html.twig', [
                'controller_name' => 'ServiceManagementController', 'address'=>$address
            ]);
        }else{
            $this->addFlash('success', 'Merci de vous identifier ou de vous enregistrer pour l\'utilisation du site.');
            return $this->redirectToRoute('app_login');
        }
    }
}
