<?php

namespace App\Controller\UserAddress;

use App\Entity\UserAddress;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserAddressDeleteController extends AbstractController
{
    #[Route('/useraddress/delete/{id}', name: 'app_useraddress_delete')]
    public function index(EntityManagerInterface $em, Request $request, UserAddress $userAddress): Response
    {
        $em->remove($userAddress);
        $em->flush();
        $this->addFlash('success', 'Suppression d\'adresse validé');
        return $this->redirectToRoute('app_profile');
    }
}
