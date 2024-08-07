<?php

namespace App\Tests\Service\Lorem;

use App\Service\Lorem;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LoremTest extends KernelTestCase
{
    public function testLorem(){
        $lowerBound = 3;
        $upperBound = 20;
        self::bootKernel();
        $lorem = self::getContainer()->get(Lorem::class);
        $string = $lorem->CreateLorem();
        $result = count(explode(' ', $string));
        $this->assertGreaterThanOrEqual($lowerBound, $result, "La longueur du texte généré est inférieure au seuil min.");
        $this->assertLessThanOrEqual($upperBound, $result, "La longueur du texte généré est supérieure au seuil max.");
    }
}