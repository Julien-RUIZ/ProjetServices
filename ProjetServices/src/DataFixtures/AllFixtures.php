<?php

namespace App\DataFixtures;

use App\Entity\GoldenBook;
use App\Entity\Service;
use App\Entity\User;
use App\Entity\UserAddress;
use App\Interface\LoremInterface;
use App\Repository\UserAddressRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * To use fixtures use the command: php bin/console doctrine:fixtures:load
 * Mode test : php bin/console doctrine:fixtures:load --env=test
 *
 * For the connection here is an example login:
 * Username : username0
 * Password : Username0%
 */

class AllFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher, private UserRepository $userRepository, private UserAddressRepository $addressRepository, private LoremInterface $lorem )
    {

    }

    public function load(ObjectManager $manager): void
    {
        for($i=0; $i<8; $i++){
            $goldenBook = new GoldenBook();
            $goldenBook->setUsername('person'.$i)
                ->setText($this->lorem->CreateLorem())
                ->setDate(new \DateTimeImmutable())
                ->setActive(true);
            $manager->persist($goldenBook);
        }
        $manager->flush();


        for ($i = 0; $i<5 ; $i++){
            $user = new User();
            $user->setId($i);
            $user->setUsername('username'.$i);
            $user->setName('Utilisateur Name');
            $user->setPassword($this->hasher->hashPassword($user, 'Username'.$i.'%'));
            $user->setFirstname('Firstname');
            $user->setEmail('utilisateur'.$i.'@services.com');
            if ($i === 0){
                $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
            }else{
                $user->setRoles(['ROLE_USER']);
            }
            $user->setVerified('1');
            $randomBirthDate = new DateTime();
            $randomBirthDate->modify('-'.mt_rand(18, 70).' years');
            $user->setDateOfBirth($randomBirthDate);
            $user->setTelephone('00000000'.$i);
            $manager->persist($user);
        }
        $manager->flush();

        $user = $this->userRepository->findAll();
        for ($i=0; $i<5; $i++){

            $userAddress = new UserAddress();
            if ($i === 0){
                $userAddress->setMainAddress(True);
            }
            $userAddress->setAddress('rue inconnu '.$i)
                ->setCity('Ville'.$i)
                ->setNumber(rand(null, 100))
                ->setUser($user[$i])
                ->setRental(rand(0,1))
                ->setPostalCode(rand(0, 99000))
                ->setDwellingSize(rand(0, 300))
                ->setDwellingType('Appartement');
            $manager->persist($userAddress);
        }
        $manager->flush();

        $address = $this->addressRepository->findAll();
        $type = ['Eau', 'Gaz', 'Électricité', 'Assurance-habitation', 'Assurance-véhicule', 'Forfait-téléphonie', 'Forfait-Box-internet', 'Autre'];
        for ($i=0; $i<20; $i++){
            $randAddress = rand(0, count($address)-1);
            $randPrice = rand(5, 1000);
            $randType = rand(0, count($type)-1);

            $service = new Service();
            $service->setUserAddress($address[$randAddress])
                ->setName($type[$randType])
                ->setLink('https://www.'.$type[$randType].'.fr')
                ->setType($type[$randType])
                ->setPriceMonth($randPrice)
                ->setPriceYear($randPrice * 12);
            $manager->persist($service);
        }
        $manager->flush();
    }
}
