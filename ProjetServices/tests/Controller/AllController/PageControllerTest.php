<?php

namespace App\Tests\Controller\AllController;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PageControllerTest extends WebTestCase // classe pour écriture tests en lien avec des requêtes et des réponses
{
    public function Identification($client){
        $userRepository = self::getContainer()->get(UserRepository::class);
        $user  = $userRepository->findOneBy(['username' => 'username1']);
        return $client->loginUser($user);
    }
    /**
     * @dataProvider dataUrl
     */
    public function testHomePage($url, $reponsehttp, $message){
        $client = static::createClient();
        $this->Identification($client);
        $client->request('GET', $url);
        $this->assertResponseStatusCodeSame($reponsehttp, $message);
    }
    /**
     * @dataProvider dataUrlAndInfo
     */
    public function testTitleAndTextHome($uri, $CatTitle, $text, $message){
        $client = static::createClient();
        $this->Identification($client);
        $client->request('GET', $uri);
        $this->assertSelectorTextContains($CatTitle, $text, $message);
    }
    public function dataUrl(){
        return [
            ['/note',Response::HTTP_OK,  'Erreur sur note'],
            ['/services',Response::HTTP_OK, 'Erreur sur services'],
            ['/',Response::HTTP_OK, 'Erreur sur home'],
            ['/profile',Response::HTTP_OK, 'Erreur sur profile'],
        ];
    }
    public function dataUrlAndInfo(){
        return [
            ['/note', 'h1', "Notes & Relances", 'Erreur sur note' ],
            ['/services','h1',  'Gestion des services', 'Erreur sur services'],
            ['/', 'h1', 'Gestion des services, pourquoi et pour qui ?', 'Erreur sur home'],
            ['/profile', 'h1', "Profil de l'utilisateur", 'Erreur sur profile'],
        ];
    }
}