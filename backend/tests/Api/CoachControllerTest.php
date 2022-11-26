<?php

namespace App\Tests\Api;

use App\Repository\CoachRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CoachControllerTest extends WebTestCase
{
    public function testApiGetCoachItem(): void
    {
        $client = static::createClient();
        $coachRepository = static::getContainer()->get(CoachRepository::class);
        
        $testcoach = $coachRepository->find(1);
        $client->loginUser($testcoach->getUser());
        
        $client->request('GET', '/api/coach/1');
        $this->assertResponseIsSuccessful();
    }
    public function testApiDeleteCoach(): void
    {
        $client = static::createClient();
        $coachRepository = static::getContainer()->get(CoachRepository::class);
        
        $testcoach = $coachRepository->find(4);
        if ($testcoach !== null) {
            $client->loginUser($testcoach->getUser());
            $client->request('DELETE', '/api/coach/2');
            $this->assertEquals(403, $client->getResponse()->getStatusCode());
        }
    }
}
