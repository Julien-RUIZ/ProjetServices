<?php

namespace App\Controller\Note;

use App\Entity\Note;
use App\Repository\NoteRepository;
use App\Security\Voter\NoteVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DeleteNoteController extends AbstractController
{
    #[Route('/delete/note/{id}', name: 'app_delete_note',requirements: ['id'=>'\d+'])]
    #[IsGranted('ROLE_USER')]
    #[IsGranted(NoteVoter::EDIT, subject: 'note')]
    public function index(Note $note, EntityManagerInterface $entityManager): Response
    {
            $entityManager->remove($note);
            $entityManager->flush();
            return $this->redirectToRoute('app_note');
    }
}
