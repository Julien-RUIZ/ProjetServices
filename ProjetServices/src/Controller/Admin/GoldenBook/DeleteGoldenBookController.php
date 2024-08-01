<?php

namespace App\Controller\Admin\GoldenBook;

use App\Entity\GoldenBook;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DeleteGoldenBookController extends AbstractController
{
    #[Route('/delete/goldenbook/{id}', name: 'app_delete_goldenbook')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(GoldenBook $goldenBook, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($goldenBook);
        $entityManager->flush();

        $this->addFlash('success', 'Suppression du message.' );
        return $this->redirectToRoute('app_admin_goldenbook');
    }
}
