<?php

namespace App\Controller\UserAddress;

use App\Entity\UserAddress;
use App\Form\UserAddressType;
use App\Security\Voter\AddressVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserAddressUpdateController extends AbstractController
{
    #[Route('/userAddress/update/{id}', name: 'app_useraddress_update')]
    #[IsGranted('ROLE_USER')]
    #[IsGranted(AddressVoter::EDIT, subject: 'userAddress')]
    public function index(Request $request, UserAddress $userAddress, EntityManagerInterface $em): Response
    {
        $form= $this->createForm(UserAddressType::class, $userAddress);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', 'Modification d\'adresse validé');
            return $this->redirectToRoute('app_profile');
        }
        return $this->render('Address/user_address_update/index.html.twig', [
            'controller_name' => 'UserAddressUpdateController', 'form'=>$form
        ]);
    }
}
