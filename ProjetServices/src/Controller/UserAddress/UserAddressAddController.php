<?php

namespace App\Controller\UserAddress;

use App\Controller\UserAddress\Rental\AutoAddRentalService;
use App\Entity\UserAddress;
use App\Form\UserAddressType;
use App\Security\Voter\AddressVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserAddressAddController extends AbstractController
{
    #[Route('/useraddress/add', name: 'app_useraddress_add')]
    #[IsGranted('ROLE_USER')]
    #[IsGranted(AddressVoter::CREATE)]
    public function index(Request $request, EntityManagerInterface $em, AutoAddRentalService $addRentalService): Response
    {
        $address = new UserAddress();
        $form= $this->createForm(UserAddressType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser();
            $address->setUser($user);
            if ($address->isRental() && !empty($address->getRentprice()) && !empty($address->getRealEstateAgency())){
               $addRentalService->addRental($address->getRentprice(), $address, $address->getRealEstateAgency());
            }
            if ($address->isRental() && empty($address->getRentprice()) || empty($address->getRealEstateAgency())){
                $this->addFlash('danger', "S'il y a location, merci d'indiquer le prix du loyer ainsi que l'agence immobilière." );
                return $this->redirectToRoute('app_useraddress_add');
            }
            $em->persist($address);
            $em->flush();
            $this->addFlash('success', 'Ajout d\'adresse validé' );
            return $this->redirectToRoute('app_profile');
        }
        return $this->render('Address/user_address_add/index.html.twig', [
            'controller_name' => 'UserAddressAddController', 'form'=>$form
        ]);
    }
}
