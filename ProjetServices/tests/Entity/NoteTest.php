<?php

namespace App\Tests\Entity;

use App\Entity\Note;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NoteTest extends KernelTestCase
{
    private $Note;
    public function setUp(): void
    {
        parent::setUp();
        $this->Note = new Note();
        $this->Note->setText('coucou');
    }
    private function NbErrors(Note $Note, $nberrors = 0){
        self::bootKernel();
        $errors = self::getContainer()->get('validator')->validate($Note);
        $this->assertCount($nberrors, $errors);
    }

    public function testValidTitle(){
        // Test si longueur inf à val max
        $this->NbErrors($this->Note->setTitle('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'), 0);
        // Test si longueur sup à val min
        $this->NbErrors($this->Note->setTitle('aaaaa'), 0);
    }
    public function testErrorTitle(){
        // Test si longueur inf à val min
        $this->NbErrors($this->Note->setTitle('aa'), 1);
        // Test si longueur sup à val max
        $this->NbErrors($this->Note->setTitle('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'), 1);
    }

    public function testErrorText(){
        // Test si longueur inf val min
        $this->NbErrors($this->Note->setText('abc'), 1);
        // Test si présence caractère spéciaux
        $this->NbErrors($this->Note->setText('<%/!!>'), 1);
    }

    public function testErrorMail(){
        $this->NbErrors($this->Note->setEmailsend('testhotmail.com'), 1);
        $this->NbErrors($this->Note->setEmailsend('@hotmail.com'), 1);
        $this->NbErrors($this->Note->setEmailsend('test@hotmail'), 1);
    }
    public function testValidMail(){
        $this->NbErrors($this->Note->setEmailsend('test@hotmail.com'), 0);
    }
}