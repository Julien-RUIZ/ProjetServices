<?php

namespace App\Controller\Fixtures;

use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserFixtureController extends AbstractController
{
    #[Route('/fixtureUser', name: 'app_fixture')]
    public function userFixture(UserPasswordHasherInterface  $hasher, EntityManagerInterface $entityManager): Response
    {

        for ($id = 0; $id<10 ; $id++){
            $user = new User();
            $user->setUsername('username'.$id);
            $user->setName('utilisateurName'.$id);
            $user->setPassword($hasher->hashPassword($user, 'username'.$id));
            $user->setFirstname('utilisateurFirstname'.$id);
            $user->setEmail('utilisateur'.$id.'@services.com');
            $user->setRoles(['ROLE_USER']);
            $user->setVerified('1');
            $randomBirthDate = new DateTime();
            $randomBirthDate->modify('-'.mt_rand(18, 70).' years');
            $user->setDateOfBirth($randomBirthDate);
            $user->setTelephone('00000000'.$id);
            $entityManager->persist($user);
        }
        $entityManager->flush();
        return $this->redirectToRoute('app_home');
    }
}