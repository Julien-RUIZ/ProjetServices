<?php

namespace App\Controller;

use App\Entity\UserAddress;
use App\Form\UserAddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserAddressAddController extends AbstractController
{
    #[Route('/useraddress/add', name: 'app_useraddress_add')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $address = new UserAddress();
        $form= $this->createForm(UserAddressType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser();
            $address->setUser($user);
            $em->persist($address);
            $em->flush();
            $this->addFlash('success', 'Ajout d\'adresse validé' );
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('user_address_add/index.html.twig', [
            'controller_name' => 'UserAddressAddController', 'form'=>$form
        ]);
    }
}
