<?php

namespace App\Controller\Note;

use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DeleteNoteController extends AbstractController
{
    #[Route('/delete/note/{id}', name: 'app_delete_note')]
    #[IsGranted('ROLE_USER')]
    public function index(NoteRepository $noteRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $requete = $request->attributes;
        $id = $requete->get('id');

        if(!empty($this->getUser())){
            $user = $this->getUser();
            $iduser = $user->getId();
            $note = $noteRepository->noteByIdAndUserid($id, $iduser);
            $entityManager->remove($note);
            $entityManager->flush();
            return $this->redirectToRoute('app_note');
        }else{
            $this->addFlash('Danger', 'Merci de vous connecter afin de profiter des options du site.');
            return $this->redirectToRoute('app_home');
        }


    }
}
