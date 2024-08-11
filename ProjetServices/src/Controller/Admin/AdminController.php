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
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminController extends AbstractController
{
    #[Route('/Admin', name: 'app_admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('Admin/index.html.twig', [
        ]);
    }
}
