<?php

namespace App\Controller\Admin\GoldenBook;


use App\Entity\GoldenBook;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class OnOffGoldenBookController extends AbstractController
{
    #[Route('/onoffgoldenbook/{id}', name: 'app_onoffgoldenbook')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(GoldenBook $goldenBook, EntityManagerInterface $entityManager)
    {
        if($goldenBook->isActive()=== true){
            $goldenBook->setActive(false);
            $entityManager->flush();
            $this->addFlash('success', 'Désactivation du message.' );
            return $this->redirectToRoute('app_admin_goldenbook');
        } else{
            $goldenBook->setActive(true);
            $entityManager->flush();
            $this->addFlash('success', 'Validation du message.' );
            return $this->redirectToRoute('app_admin_goldenbook');
        }
    }
}
