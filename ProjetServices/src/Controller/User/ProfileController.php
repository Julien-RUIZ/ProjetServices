<?php

namespace App\Controller\User;

use App\Repository\UserAdressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(UserAdressRepository $userAdressRepository): Response
    {
       $user = $this->getUser();
       $user_id = $user->getId();
       $address = $userAdressRepository->findByUserId($user_id);

       //dd($address);
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController', 'address'=>$address, 'user'=>$user
        ]);
    }
}
