<?php

namespace App\Controller\Admin\GoldenBook;

use App\Repository\GoldenBookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminGoldenBook extends AbstractController
{
    #[Route('/Admin/GoldenBook', name: 'app_admin_goldenbook')]
    public function index(GoldenBookRepository $goldenBookRepository): Response
    {
        $AllGoldenBooks = $goldenBookRepository->findAll();
        return $this->render('Admin/AdminGoldenBook/index.html.twig', [
            'AllGoldenBooks' => $AllGoldenBooks
        ]);
    }
}