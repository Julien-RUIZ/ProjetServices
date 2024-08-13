<?php

namespace App\Controller\Note;

use App\Entity\Note;
use App\Form\NoteType;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\AST\Functions\CurrentDateFunction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class NoteController extends AbstractController
{
    private $form;
    private $tab=[];
    private $notes;

    #[Route('/note', name: 'app_note')]
    #[IsGranted('ROLE_USER')]
    public function AddNote(EntityManagerInterface $entityManager, Request $request, NoteRepository $noteRepository, Reminder $reminder): Response
    {
        if(!empty($this->getUser())){
            $value = $request->request->all('note');
            if (isset($value['save'])){
                $id = $value['save'];
                $user = $this->getUser();
                $note = $noteRepository->noteByIdAndUserid($id, $user->getId());
                $form = $this->createForm(NoteType::class, $note);
                $form->handleRequest($request);
                if($form->isSubmitted() && $form->isValid()){
                    $user = $this->getUser();
                    $note->setUser($user);
                    $note->setdatemodif($reminder->CurrentDate());
                    $entityManager->persist($note);
                    $entityManager->flush();
                    $this->addFlash('success', "Message enregistré");
                    return $this->redirectToRoute('app_note');
                }
            }else{
                $user = $this->getUser();
                $this->notes = $noteRepository->noteByUserid($user->getId());

                foreach ($this->notes as $note){
                    $this->form = $this->createForm(NoteType::class, $note);
                    $this->tab[] = $this->form->createView();
                }
            }
            return $this->render('Note/note/index.html.twig', [
                'form' => $this->form, 'tab'=>$this->tab, 'notes'=>$this->notes
            ]);
        }else{
            return $this->redirectToRoute('app_home');
        }
    }
}
