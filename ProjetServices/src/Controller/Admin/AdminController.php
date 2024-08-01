<?php

namespace App\Controller\Admin;

use App\Entity\GoldenBook;
use App\Form\ActiveGoldenBookType;
use App\Form\GoldenBookType;
use App\Repository\GoldenBookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/Admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('Admin/index.html.twig', [
        ]);
    }
}
