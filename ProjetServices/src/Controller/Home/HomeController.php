<?php

namespace App\Controller\Home;

use App\Repository\GoldenBookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(GoldenBookRepository $goldenBookRepository): Response
    {

        $GoldenBooks = $goldenBookRepository->findGoldenBookActive();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController', 'GoldenBooks' => $GoldenBooks
        ]);
    }
}
