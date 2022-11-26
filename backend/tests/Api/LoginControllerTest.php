<?php

namespace App\Tests\Api;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testApiLoginController(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('user0@gmail.com');
        $client->loginUser($testUser);
        
        $client->request('POST', '/api/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }
}
