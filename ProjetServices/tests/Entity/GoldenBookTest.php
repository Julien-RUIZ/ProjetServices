<?php

namespace App\Tests\Entity;

use App\Entity\GoldenBook;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GoldenBookTest extends KernelTestCase
{
    private $goldenBook;
    protected function setUp(): void
    {
        $this->goldenBook = new GoldenBook();
        $this->goldenBook->setActive(true)
            ->setDate(new \DateTimeImmutable())
            ->setUsername('User')
            ->setText('Juste un mot en test')
            ->setUser(NULL);
    }
    private function NbErrors($goldenBook, $nberrors = 0){
        self::bootKernel();
        $errors = self::getContainer()->get('validator')->validate($this->goldenBook);
        foreach ($errors as $error){
            $message[] = $error->getPropertyPath(). '=>' . $error->getMessage();
        }
        $this->assertCount($nberrors, $errors, implode(',',$message));
    }
    public function testValidEntity(){
        $this->NbErrors($this->goldenBook, 0);
    }
    public function testErrorEntity(){
        $this->NbErrors($this->goldenBook->setText('abcd'), 1);
    }
}