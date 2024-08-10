<?php

namespace App\Tests\Entity;

use App\Entity\UserAddress;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserAddressTest extends KernelTestCase
{
    private $userAddress;
    public function setUp(): void
    {
        $this->userAddress = new UserAddress();
    }

    public function TestUserAddress(UserAddress $userAddress, $nberror ){
        self::bootKernel();
        $error = self::getContainer()->get('validator')->validate($userAddress);
        //dd($error);
        $this->assertCount($nberror, $error);
    }
    public function testValidAddress(){
        $this->TestUserAddress($this->userAddress->setAddress('une address'), 0);
    }
    public function testErrorAddress(){
        $this->TestUserAddress($this->userAddress->setAddress(''), 1);
    }
    public function testValidDwellingType(){
        $this->TestUserAddress($this->userAddress->setDwellingType("Appartement"), 0);
    }
    public function testErrorDwellingType(){
        $this->TestUserAddress($this->userAddress->setDwellingType(354), 1);
    }
    public function testValidRentprice(){
        $this->TestUserAddress($this->userAddress->setRentprice(5), 0);
    }
    public function testErrorRentprice(){
        $this->TestUserAddress($this->userAddress->setRentprice(-651), 1);
        // Test avec nb caractère inf à val min
        $this->TestUserAddress($this->userAddress->setRentprice(2), 1);
        // Test avec nb caractère sup à val max
        $this->TestUserAddress($this->userAddress->setRentprice(1000001), 1);
    }

    public function testValidRealEstateAgency(){
        $this->TestUserAddress($this->userAddress->setRealEstateAgency('Agence22'), 0);
    }
    public function testErrorRealEstateAgency(){
        // Test avec nb caractère inf à val min
        $this->TestUserAddress($this->userAddress->setRealEstateAgency('A22'), 1);
        // Test avec 101 caractères sup à val max
        $this->TestUserAddress($this->userAddress->setRealEstateAgency('Lorem ipsum dolor sit amet, consectetur adipiscing elita.'), 1);
    }
}