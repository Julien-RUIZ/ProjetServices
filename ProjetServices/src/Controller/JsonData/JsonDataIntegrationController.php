<?php

namespace App\Controller\JsonData;

use App\Entity\Service;
use App\Entity\UserAddress;
use App\Repository\UserAddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class JsonDataIntegrationController extends AbstractController
{
    #[Route('/json/data/integration', name: 'app_json_data_integration')]
    #[IsGranted('ROLE_USER')]
    public function index(Filesystem $filesystem, SerializerInterface $serializer,
                          EntityManagerInterface $entityManager,
                          UserAddressRepository $userAddressRepository): Response
    {
        if ($this->getUser()){
            $userid = $this->getUser()->getid();
            $link = $this->getParameter('kernel.project_dir');
            $linkJson = $link.'/data/JsonDataExtract/jsondataextract'.$userid.'.json';

            if ($filesystem->exists($linkJson)){
                $datajson = file_get_contents($linkJson);

                $deserializeJson = $serializer->deserialize($datajson, 'App\Entity\UserAddress[]', 'json',[
                    'groups'=>'jsondataInteg',
                ]);
                foreach ($deserializeJson as $data){
                    $collectionService = $data->getService();
                    dd($datajson, count($collectionService));
                    foreach ($collectionService as $service){
                        dd($service);
                    }
                    // $data->getUserAddress()->setUser($this->getUser());
                    $data->setUser($this->getUser());
                    //$entityManager->persist($data);
                }
                //$entityManager->flush();

                $this->addFlash('success', 'L\'intégration de vos données a été réalisée avec succès.' );
            }else{
                $this->addFlash('success', 'Vous ne possédez pas de document pour l\'intégration de données.');
            }
            return $this->redirectToRoute('app_profile');
        }else{
            $this->addFlash('success', 'Merci de vous identifier ou de vous enregistrer pour l\'utilisation du site.');
            return $this->redirectToRoute('app_login');
        }
    }
}