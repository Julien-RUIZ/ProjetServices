<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\Voter\UserProjetVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserUpdateController extends AbstractController
{
    #[Route('/user/update/{id}', name: 'app_user_update',requirements: ['id'=>'\d+'])]
    #[IsGranted('ROLE_USER')]
    #[IsGranted(UserProjetVoter::EDIT, subject: 'user')]
    public function index(Request $request, User $user, EntityManagerInterface $em, UserRepository $userRepository): Response
    {
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $em->flush();
                $this->addFlash('success', 'Félicitation la modification de vos données personnelles sont enregistrés.');
                return $this->redirectToRoute('app_profile');
            }
            return $this->render('User/user_update/index.html.twig', [
                'controller_name' => 'UserUpdateController', 'form'=>$form
            ]);
    }
}
