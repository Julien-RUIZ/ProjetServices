<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Security\Voter\UserProjetVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Security\User\EntityUserProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserDeleteController extends AbstractController
{
    #[Route('/user/delete/{id}', name: 'app_user_delete',requirements: ['id'=>'\d+'])]
    #[IsGranted('ROLE_USER')]
    #[IsGranted(UserProjetVoter::EDIT, subject: 'user')]
    public function delete(User $user, EntityManagerInterface $entityManager): Response
    {
                $entityManager->remove($user);
                $entityManager->flush();
                $session = new Session();
                $session->invalidate();
                return $this->redirectToRoute('app_logout');
    }

    #[Route('/user/infoDelete/{id}', name: 'app_user_infoDelete')]
    #[IsGranted(UserProjetVoter::EDIT, subject: 'user')]
    public function infoDelete(User $user): Response
    {
        return $this->render('User/user_delete/index.html.twig', [
            'user'=>$user
        ]);
    }

}
