<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Repository\UserAddressRepository;
use Doctrine\ORM\EntityManagerInterface;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserDeleteController extends AbstractController
{
    /**
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @param UserAddressRepository $userAddressRepository
     * @return Response
     * Suppression des address de l'utilisateur avant suppression de l'utilisateur
     */
    #[Route('/user/delete/{id}', name: 'app_user_delete')]
    public function delete(User $user, EntityManagerInterface $entityManager, UserAddressRepository $userAddressRepository ): Response
    {
        $userid = $user->getId();
        $bob = $userAddressRepository->findByUserId($userid);
        for ($i= 0; $i<count($bob); $i++){
            $entityManager->remove($bob[$i]);
        }
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('succes','Le compte a était supprimer avec succès');
        return $this->redirectToRoute('app_home');
    }


    #[Route('/user/infoDelete/{id}', name: 'app_user_infoDelete')]
    public function infoDelete(User $user): Response
    {

        return $this->render('user_delete/index.html.twig', [
            'user'=>$user
        ]);
    }

}
