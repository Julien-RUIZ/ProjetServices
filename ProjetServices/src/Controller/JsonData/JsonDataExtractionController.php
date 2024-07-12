<?php

namespace App\Controller\JsonData;

use App\Repository\ServiceRepository;
use App\Repository\UserAddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class JsonDataExtractionController extends AbstractController
{
    #[Route('/json/data/extraction', name: 'app_json_data_extraction')]
    #[IsGranted('ROLE_USER')]
    public function index(UserAddressRepository $userAddressRepository,
                          SerializerInterface $serializer,
                          EntityManagerInterface $entityManager): RedirectResponse
    {
        if($this->getUser()){
            $userid = $this->getUser()->getid();
            $jasondata = $userAddressRepository->findBy(['user'=>$userid]);

            $serializJson = $serializer->serialize($jasondata, 'json',[
                AbstractNormalizer::GROUPS=>'jsondataextract',
            ]);

            //put in file in data folder
            $projectDir = $this->getParameter('kernel.project_dir');
            $filePath = $projectDir.'/data/JsonDataExtract/jsondataextract'.$userid.'.json';
            file_put_contents($filePath, $serializJson);

            //Deleting information after serialization
            $AllAddressByUser = $userAddressRepository->findByUserId($userid);
            foreach ($AllAddressByUser as $address){
                $entityManager->remove($address);
            }
            $entityManager->flush();

            $this->addFlash('success', 'L\'extraction des données est complète !!!');
            return $this->redirectToRoute('app_profile');
        }else{
            $this->addFlash('success', 'Merci de vous identifier ou de vous enregistrer pour l\'utilisation du site.');
            return $this->redirectToRoute('app_login');
        }
    }
}
