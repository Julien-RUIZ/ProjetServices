<?php

namespace App\Tests\Repository\User;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    public function testCount(){
        self::bootKernel(); // va instancier le kernel

        $nbusers = self::getContainer()->get(UserRepository::class)->count([]);
        $users = self::getContainer()->get(UserRepository::class)->findAll();
        //dd($users);
        $this->assertEquals(5, $nbusers);
    }
}
