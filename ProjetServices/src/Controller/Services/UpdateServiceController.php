<?php

namespace App\Controller\Services;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use App\Security\Voter\ServiceVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
class UpdateServiceController extends AbstractController
{
    #[Route('/update/service/{id}', name: 'app_update_service')]
    #[IsGranted('ROLE_USER')]
    #[IsGranted(ServiceVoter::EDIT, subject: 'service')]
    public function index(Service $service, EntityManagerInterface $entityManager, Request $request, ServiceRepository $serviceRepository): Response
    {
            $form = $this->createForm(ServiceType::class, $service);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $entityManager->flush();
                $this->addFlash('success', 'Modification du service enregistré');
                return $this->redirectToRoute('app_service_management');
            }
            return $this->render('Service/update_service/index.html.twig', [
                'controller_name' => 'UpdateServiceController', 'form'=>$form
            ]);
    }
}
