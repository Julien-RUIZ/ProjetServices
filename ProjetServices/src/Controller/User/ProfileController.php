<?php

namespace App\Controller\User;

use App\Repository\UserAddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProfileController extends AbstractController
{

    #[IsGranted('ROLE_USER')]
    #[Route('/profile', name: 'app_profile')]
    public function index(UserAddressRepository $userAddressRepository, Request $request): Response
    {
        if($this->getUser()){
            $user = $this->getUser();
            $user_id = $user->getId();
            $page = $request->query->getInt('page', 1);
            $limit = 3;
            $address = $userAddressRepository->paginateUserAddress($page, $limit, $user_id, );
            //dd($address);
            $nbAddress = $address->count();
            $maxPage = ceil($address->count()/$limit);
            return $this->render('profile/index.html.twig', [
                'controller_name' => 'ProfileController', 'address'=>$address, 'user'=>$user, 'page' =>$page, 'maxPage'=>$maxPage, 'limit'=>$limit,
                'nbAddress'=>$nbAddress
            ]);
        }else{
            $this->addFlash('warning', 'Merci de vous identifier afin de profiter des fonctionnalités du site.');
            return $this->redirectToRoute('app/login');
        }
    }
}
