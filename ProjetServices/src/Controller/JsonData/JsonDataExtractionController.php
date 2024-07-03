<?php

namespace App\Controller\JsonData;

use App\Repository\ServiceRepository;
use App\Repository\UserAddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class JsonDataExtractionController extends AbstractController
{
    #[Route('/json/data/extraction', name: 'app_json_data_extraction')]
    public function index(UserAddressRepository $userAddressRepository, ServiceRepository $serviceRepository, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        if($this->getUser()){
            $userid = $this->getUser()->getid();
            $jasondata = $serviceRepository->UserAdressAndServiceByUserid($userid);

            $serializJson = $serializer->serialize($jasondata, 'json',[
                AbstractNormalizer::GROUPS=>'jsondataextract',
            ]);

            //mettre en fichier dans le dossier data
            $projectDir = $this->getParameter('kernel.project_dir');
            $filePath = $projectDir.'/data/JsonDataExtract/jsondataextract'.$userid.'.json';
            file_put_contents($filePath, $serializJson);

            //Suppression des infos aprés la sérialisation
            $AllAddressByUser = $userAddressRepository->findByUserId($userid);
            foreach ($AllAddressByUser as $address){
                $entityManager->remove($address);
            }
            $entityManager->flush();

            //return new JsonResponse($serializJson, 200, [], true);
            $this->addFlash('success', 'L\'extraction des données est complète !!!');
            return $this->redirectToRoute('app_profile');
        }else{
            $this->addFlash('success', 'Merci de vous identifier ou de vous enregistrer pour l\'utilisation du site.');
            return $this->redirectToRoute('app_login');
        }
    }
}
