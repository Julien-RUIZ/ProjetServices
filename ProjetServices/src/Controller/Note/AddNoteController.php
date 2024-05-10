<?php

namespace App\Controller\Note;

use App\Entity\Note;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AddNoteController extends AbstractController
{
    #[Route('/add/note', name: 'app_add_note')]
    #[IsGranted('ROLE_USER')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        if (!empty($this->getUser())){
            $user = $this->getUser();
            $note = new Note();
            $note->setTitle('');
            $note->setText('');
            $note->setUser($user);
            $entityManager->persist($note);
            $entityManager->flush();
            return $this->redirectToRoute('app_note');
        }else{
            $this->addFlash('Danger', 'Merci de vous connecter afin de profiter des options du site.');
            return $this->redirectToRoute('app_home');
        }
    }
}
