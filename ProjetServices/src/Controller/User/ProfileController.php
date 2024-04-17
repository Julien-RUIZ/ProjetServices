<?php

namespace App\Controller\User;

use App\Repository\UserAddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(UserAddressRepository $userAddressRepository): Response
    {

       $user = $this->getUser();
       $user_id = $user->getId();
       $address = $userAddressRepository->findByUserId($user_id);

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController', 'address'=>$address, 'user'=>$user
        ]);
    }
}
