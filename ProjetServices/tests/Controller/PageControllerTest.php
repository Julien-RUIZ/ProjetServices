<?php

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PageControllerTest extends WebTestCase // classe pour ecriture tests en lien avec des requêtes et des réponses
{
    public function testHomePage(){
        $client = static::createClient(); //méthode qui va donner un client

        $client->request('GET', '/'); //client avec requête
        //dd($client->request('GET', '/'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}