<?php

namespace App\Tests\Entity;


use App\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ServiceTest extends KernelTestCase
{
    private $Service;
    public function setUp(): void
    {
      $this->Service = new Service();
    }
    public function TestService(Service $service, $nberror){
      self::bootKernel();
      $errors = self::getContainer()->get('validator')->validate($service);
      $this->assertCount($nberror, $errors);
    }

    public function testValidName(){
        $this->TestService($this->Service->setName('name'), 0);
        $this->TestService($this->Service->setName('name one'), 0);
        $this->TestService($this->Service->setName('name-one'), 0);
    }
    public function testErrorName(){
        $this->TestService($this->Service->setName(654), 1);
        $this->TestService($this->Service->setName('name465'), 1);
    }

    public function testValidLink(){
        $this->TestService($this->Service->setLink('https://www.julien-ruiz.fr/'), 0);
    }
    public function testErrorLink(){
        $this->TestService($this->Service->setLink('<?php @?>'), 1);
    }

    public function testValidPriceMonth(){
        $this->TestService($this->Service->setPriceMonth(100), 0);
    }
    public function testErrorPriceMonth(){
        $this->TestService($this->Service->setPriceMonth(2), 1);
    }

    public function testValidPriceYear(){
        $this->TestService($this->Service->setPriceYear(100), 0);
    }

    public function testErrorPriceYear(){
        $this->TestService($this->Service->setPriceYear(2), 1);
    }
}