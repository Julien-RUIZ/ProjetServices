<?php

namespace App\Tests\Repository;

use App\Repository\GoldenBookRepository;
use App\Repository\ServiceRepository;
use App\Repository\UserAddressRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RepositoryTest extends KernelTestCase
{
    /**
     * @dataProvider dataRepository
     */
    public function testCount($repo, $nbElements, $message){
        self::bootKernel();
        $nbusers = self::getContainer()->get($repo)->count([]);
        $this->assertEquals($nbElements, $nbusers, $message);
    }

    public function dataRepository(){
        return [
            [UserRepository::class, 5, "Erreur sur User"],
            [GoldenBookRepository::class, 8, "Erreur sur GoldenBook"],
            [UserAddressRepository::class, 5, "Erreur sur UserAddress"],
            [ServiceRepository::class, 20, "Erreur sur Service"]

        ];
    }

}
