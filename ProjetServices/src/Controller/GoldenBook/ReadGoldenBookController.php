<?php

namespace App\Controller\GoldenBook;

use App\Entity\GoldenBook;
use App\Form\GoldenBookType;
use App\Repository\GoldenBookRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ReadGoldenBookController extends AbstractController
{
    #[Route('/goldenbook', name: 'app_goldenbook')]
    #[IsGranted('ROLE_USER')]
    public function index(GoldenBookRepository $goldenBookRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        if ($this->getUser()->getGoldenBook() === null){
            $GoldenBook = new GoldenBook();
            $form = $this->createForm(GoldenBookType::class, $GoldenBook);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $GoldenBook->setDate(new \DateTimeImmutable());
                $GoldenBook->setActive(false);
                $GoldenBook->setUser($this->getUser());
                $entityManager->persist($GoldenBook);
                $entityManager->flush();
                $this->addFlash('success', 'Ajout du message dans le livre d\or validé' );
                return $this->redirectToRoute('app_goldenbook');
            }
            $ActiveGoldenBooks = $goldenBookRepository->findGoldenBookActive();

            return $this->render('Goldenbook/index.html.twig', [
                'ActiveGoldenBooks' => $ActiveGoldenBooks, 'form'=>$form
            ]);
        }else{
            $ActiveGoldenBooks = $goldenBookRepository->findGoldenBookActive();

            return $this->render('Goldenbook/index.html.twig', [
                'ActiveGoldenBooks' => $ActiveGoldenBooks
            ]);
        }


    }
}
