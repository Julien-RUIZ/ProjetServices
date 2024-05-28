<?php

namespace App\Controller\JsonData;

use App\Entity\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class JsonDataIntegrationController extends AbstractController
{
    #[Route('/json/data/integration', name: 'app_json_data_integration')]
    public function index(Filesystem $filesystem, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()){
            $userid = $this->getUser()->getid();
            $link = $this->getParameter('kernel.project_dir');
            $linkJson = $link.'/data/JsonDataExtract/jsondataextract'.$userid.'.json';
            if ($filesystem->exists($linkJson)){
                $datajson = file_get_contents($linkJson);
                $deserializeJson = $serializer->deserialize($datajson, 'App\Entity\service[]', 'json', [
                    'groups'=>'jsondataextract'
                ]);
                foreach ($deserializeJson as $datajson){
                    $datajson->getUserAddress()->setUser($this->getUser());
                    $entityManager->persist($datajson);
                }
                $entityManager->flush();

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
