<?php

namespace App\Controller\Fixtures;

use App\Entity\Service;
use App\Entity\UserAddress;
use App\Repository\ServiceRepository;
use App\Repository\UserAddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServiceFixtureController extends AbstractController
{
    #[Route('/service/fixture', name: 'app_service_fixture')]
    public function ServiceFixture(ServiceRepository $serviceRepository, EntityManagerInterface $entityManager, UserAddressRepository $addressRepository): Response
    {
        $service = $serviceRepository->findAll();
        if(!empty($service)){
            $this->addFlash('danger','Si vous souhaitez réinitialiser un jeu de fixture, merci d\'utiliser le lien : /all/fixture');
            return $this->redirectToRoute('app_home');
        }else{
            $address = $addressRepository->findAll();
            $type = ['Eau', 'Gaz', 'Électricité', 'Assurance-habitation', 'Assurance-véhicule', 'Forfait-téléphonie', 'Forfait-Box-internet', 'Autre'];
            for ($i=0; $i<10; $i++){
                $randAddress = rand(0, count($address)-1);
                $randPrice = rand(5, 1000);
                $randType = rand(0, count($type)-1);
                $service = new Service();
                $service->setUserAddress($address[$randAddress])
                    ->setName($type[$randType])
                    ->setLink('https://www.'.$type[$randType].'.fr')
                    ->setType($type[$randType])
                    ->setPriceMonth($randPrice)
                    ->setPriceYear($randPrice * 10);
                $entityManager->persist($service);
            }
            $entityManager->flush();
            $this->addFlash('success','Toutes les données en bdd sont réinitialisées, bonne journée !!!.');
            return $this->redirectToRoute('app_home');
        }

    }
}
