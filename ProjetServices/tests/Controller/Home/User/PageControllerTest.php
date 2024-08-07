<?php

namespace App\Tests\Controller\Home\User;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase // classe pour écriture tests en lien avec des requêtes et des réponses
{
    public function testHomePage(){

        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertSelectorTextContains('h1', 'Gestion des services, pourquoi et pour qui ?');

    }
}