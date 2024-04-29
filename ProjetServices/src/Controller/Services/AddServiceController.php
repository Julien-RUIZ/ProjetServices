<?php

namespace App\Controller\Services;

use App\Entity\Service;
use App\Entity\UserAddress;
use App\Form\ServiceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddServiceController extends AbstractController
{
    #[Route('/service/registration/{id}', name: 'app_add_service')]
    public function registration(Request $request, EntityManagerInterface $entityManager, UserAddress $address ): Response
    {
        $service = new Service();
        $form =$this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $service->setUserAddress($address);
            $entityManager->persist($service);
            $entityManager->flush();
            $this->addFlash('success','L\'enregistrement du nouveau service est validé' );
            return $this->redirectToRoute('app_service_management');
        }

        return $this->render('/Service/add_service/index.html.twig', [
            'controller_name' => 'AddServiceController', 'form'=>$form
        ]);
    }
}
