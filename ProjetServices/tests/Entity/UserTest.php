<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    private $User;
    public function setUp(): void
    {
        $this->User = new User();
    }
    public function TestUser(User $user, $nberror ){
        self::bootKernel();
        $error = self::getContainer()->get('validator')->validate($user);
        //dd($error);
        $this->assertCount($nberror, $error);
    }
    public function testValidUsername(){
        //unique et comportant la demande du regex
        $this->TestUser($this->User->setUsername('Username132'), 0);
        $this->TestUser($this->User->setUsername('username'), 0);
        $this->TestUser($this->User->setUsername('username-bob'), 0);
        $this->TestUser($this->User->setUsername('username-32'), 0);
    }
    public function testErrorUsername(){
        $this->TestUser($this->User->setUsername('Username 32'), 1);
        $this->TestUser($this->User->setUsername('User'), 1);
    }
    public function testValidPassword(){
        $this->TestUser($this->User->setPassword('Username32'), 0);
        $this->TestUser($this->User->setPassword('Username320%'), 0);
        $this->TestUser($this->User->setPassword('Username-320%'), 0);
    }
    public function testErrorPassword(){
        $this->TestUser($this->User->setPassword('username32'), 1);
        $this->TestUser($this->User->setPassword('Userna%'), 1);
        $this->TestUser($this->User->setPassword('Username 320%'), 1);
    }
    public function testValidEmail(){
        $this->TestUser($this->User->setEmail('username@hotmail.com'), 0);
        $this->TestUser($this->User->setEmail('username@hotmail.fr'), 0);
    }
    public function testErrorEmail(){
        $this->TestUser($this->User->setEmail('@hotmail.com'), 1);
        $this->TestUser($this->User->setEmail('username@.fr'), 1);
        $this->TestUser($this->User->setEmail('username@hotmail.'), 1);
        $this->TestUser($this->User->setEmail('username@'), 1);
    }

    public function testValidFirstname(){
        $this->TestUser($this->User->setFirstname('Élise'), 0);
        $this->TestUser($this->User->setFirstname('Benoît'), 0);
        $this->TestUser($this->User->setFirstname('Marie-Claire'), 0);
        $this->TestUser($this->User->setFirstname('Marie Claire'), 0);
    }
    public function testErrorFirstname(){
        $this->TestUser($this->User->setFirstname(100), 1);
        $this->TestUser($this->User->setFirstname('Élise100'), 1);

    }
}