<?php

namespace App\Controller\Services;

use App\Entity\Service;
use App\Security\Voter\ServiceVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DeleteServiceController extends AbstractController
{
    #[Route('/delete/service/{id}', name: 'app_delete_service')]
    #[IsGranted('ROLE_USER')]
    #[IsGranted(ServiceVoter::CREATE, subject: 'service')]
    public function index(Service $service, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($service);
        $entityManager->flush();
        $this->addFlash('success', 'Le service est supprimé avec succès.');
        return $this->redirectToRoute('app_service_management');
    }
}
