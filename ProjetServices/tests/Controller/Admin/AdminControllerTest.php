<?php

namespace App\Tests\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AdminControllerTest extends WebTestCase
{
    public function testAdminPageWithoutRole(){
        $client = static::createClient();
        $client->request('GET', '/Admin');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND); // 302 Found : Page demandée a été trouvée, mais l'utilisateur est redirigé vers une autre URL
        $this->assertResponseRedirects('/login');// Teste de Redirection sur page
    }
    public function testAdminPageWithRoleUser(){
        $client= static::createClient();
        $entityManager = self::getContainer()->get('doctrine')->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['username' => 'username1']);
        $client->loginUser($user);
        $client->request('GET', '/Admin');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN); // 403 (Forbidden) : Si l'utilisateur est authentifié mais n'a pas le rôle requis, il recevra un accès interdit.
    }
    public function testAdminPageWithRoleAdmin(){
        $client= static::createClient();
        $userRepository = self::getContainer()->get(UserRepository::class);
        $user  = $userRepository->findOneBy(['username' => 'username0']);
        $client->loginUser($user);
        $client->request('GET', '/Admin');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK); // 200 OK : Indique que la page a été trouvée et affichée correctement.
    }
}