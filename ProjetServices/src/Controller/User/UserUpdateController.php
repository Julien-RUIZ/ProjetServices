<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserUpdateController extends AbstractController
{
    #[Route('/user/update/{id}', name: 'app_user_update', methods: ['GET', 'POST'])]
    public function index(Request $request, User $user, EntityManagerInterface $em): Response
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
