<?php

namespace App\Tests\Api;

use App\Repository\TriathleteRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TriathleteControllerTest extends WebTestCase
{
    public function testApiGetTrainingsbyTriathleteCollection(): void
    {
        $client = static::createClient();
        $triathleteRepository = static::getContainer()->get(TriathleteRepository::class);
        
        $testTriathlete = $triathleteRepository->find(5);
        $client->loginUser($testTriathlete->getUser());
        
        $client->request('GET', 'api/triathletes/5/trainings');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
