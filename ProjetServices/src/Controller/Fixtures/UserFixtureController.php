<?php

namespace App\Controller\Fixtures;

use App\Entity\User;
use App\Repository\UserAddressRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserFixtureController extends AbstractController
{
    #[Route('/fixtureUser', name: 'app_fixture')]
    public function UserFixture(UserAddressRepository $addressRepository,UserRepository $userRepository,UserPasswordHasherInterface $hashes, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->findAll();
        if(!empty($user)){
            $this->addFlash('danger','Si vous souhaitez réinitialiser un jeu de fixture, merci d\'utiliser le lien : /all/fixture');
            return $this->redirectToRoute('app_home');
        }else{
            for ($id = 0; $id<10 ; $id++){
                $user = new User();
                $user->setUsername('username'.$id);
                $user->setName('Utilisateur Name');
                $user->setPassword($hashes->hashPassword($user, 'Username'.$id.'%'));
                $user->setFirstname('Firstname');
                $user->setEmail('utilisateur'.$id.'@services.com');
                if ($id === 0){
                    $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
                }else{
                    $user->setRoles(['ROLE_USER']);
                }
                $user->setVerified('1');
                $randomBirthDate = new DateTime();
                $randomBirthDate->modify('-'.mt_rand(18, 70).' years');
                $user->setDateOfBirth($randomBirthDate);
                $user->setTelephone('00000000'.$id);
                $entityManager->persist($user);
            }
            $address = $addressRepository->findAll();
            foreach ($address as $value){
                $entityManager->remove($value);
            }
            $entityManager->flush();
            return $this->redirectToRoute('app_fixture_address');
        }


    }
}