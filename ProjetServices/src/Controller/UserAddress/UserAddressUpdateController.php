<?php

namespace App\Controller\UserAddress;

use App\Entity\UserAddress;
use App\Form\UserAddressType;
use App\Repository\ServiceRepository;
use App\Security\Voter\AddressVoter;
use App\Service\Rental\AutoAddRentalService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserAddressUpdateController extends AbstractController
{
    private $Loyer = null;
    private $rentService;

    #[Route('/userAddress/update/{id}', name: 'app_useraddress_update',requirements: ['id'=>'\d+'])]
    #[IsGranted('ROLE_USER')]
    #[IsGranted(AddressVoter::EDIT, subject: 'userAddress')]
    public function index(AutoAddRentalService $addRentalService, ServiceRepository $serviceRepository, Request $request, UserAddress $userAddress, EntityManagerInterface $em): Response
    {
        $form= $this->createForm(UserAddressType::class, $userAddress);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            //Test s'il existe ou non un service Loyer
            $services = $serviceRepository->findservice($userAddress->getId());
            $this->LoyerTrueOrFalse($services);
            if ($userAddress->isRental() === true && $this->Loyer === false){
                $addRentalService->addRental($userAddress->getRentprice(), $userAddress, $userAddress->getRealEstateAgency());
            }elseif ($userAddress->isRental() === false && $this->Loyer === true){
                $em->remove($this->rentService);
            }
            $em->flush();
            $this->addFlash('success', 'Modification d\'adresse validé');
            return $this->redirectToRoute('app_profile');
        }
        return $this->render('Address/user_address_update/index.html.twig', [
            'controller_name' => 'UserAddressUpdateController', 'form'=>$form
        ]);
    }

    /**
     * @param $services
     * @return void
     * Rental service attached to this address
     */
    private function LoyerTrueOrFalse($services){
        if (empty($services)){
            $this->Loyer = false;
        }else{
            for ($i=0; $i<count($services); $i++){
                if ($services[$i]->getname() === 'Loyer' ){
                    $this->Loyer = true;
                    $this->rentService = $services[$i];
                }else{
                    $this->Loyer = false;
                }
            }
        }
    }
}
