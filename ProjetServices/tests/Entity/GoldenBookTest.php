<?php

namespace App\Tests\Entity;

use App\Entity\GoldenBook;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    private function NbErrors(GoldenBook $goldenBook, $nberrors = 0){
        self::bootKernel();
        $errors = self::getContainer()->get('validator')->validate($goldenBook);
        $this->assertCount($nberrors, $errors);
    }
    public function testEntity(){
        $this->NbErrors($this->goldenBook, 0);
    }
    public function testText(){
        // Test pour texte sup à val min
        $this->NbErrors($this->goldenBook->setText('abcde'), 0);
        // Test pour texte inf à val min
        $this->NbErrors($this->goldenBook->setText('abcd'), 1);
        // Test pour texte sup à val max
        $this->NbErrors($this->goldenBook->setText('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'), 1);
    }
    public function testUsername(){
        // Test si nbcaractère inf a val min
        $this->NbErrors($this->goldenBook->setUsername('a'), 1);
        // Test si nbcaractère inf a val min
        $this->NbErrors($this->goldenBook->setUsername('aaaaaaaaaaaaaaaa'), 1);
        // Test si nbcaractère est correct
        $this->NbErrors($this->goldenBook->setUsername('aaaaaaaaaaaaaaa'), 0);
    }
}