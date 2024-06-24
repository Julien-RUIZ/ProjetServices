<?php

namespace App\Controller\JsonData;


use App\Entity\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


class JsonDataIntegrationController extends AbstractController
{
    #[Route('/json/data/integration', name: 'app_json_data_integration', methods: ['POST'])]
    public function index(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {


        $recep = $serializer->deserialize($request->getContent(), 'App\Entity\Service[]', 'json', [
        AbstractNormalizer::GROUPS=>"jsondataextract"
        ]);
        //dd($recep);
        foreach ($recep as $datajson){
            $datajson->getUserAddress()->setUser($this->getUser());
            $entityManager->persist($datajson);
        }
        $entityManager->flush();
        return new JsonResponse($request->getContent(), 200, [], true);

    }
}
