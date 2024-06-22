<?php

namespace App\Controller\UserAddress;

use App\Entity\UserAddress;
use App\Security\Voter\AddressVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserAddressDeleteController extends AbstractController
{
    #[Route('/useraddress/delete/{id}', name: 'app_useraddress_delete',requirements: ['id'=>'\d+'])]
    #[IsGranted('ROLE_USER')]
    #[IsGranted(AddressVoter::EDIT, subject: 'userAddress')]
    public function index(EntityManagerInterface $em, UserAddress $userAddress): Response
    {
        $em->remove($userAddress);
        $em->flush();
        $this->addFlash('success', 'Suppression d\'adresse validée');
        return $this->redirectToRoute('app_profile');
    }
}
