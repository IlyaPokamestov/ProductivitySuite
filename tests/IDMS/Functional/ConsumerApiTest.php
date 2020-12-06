<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\IDMS\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConsumerApiTest extends WebTestCase
{
    public function testRegisterConsumer()
    {
        $client = self::createClient([], ['CONTENT_TYPE' => 'application/json']);

        $consumer = [
            "username" => "IlyaPokamestov",
            "firstName" => "Ilya",
            "lastName" => "Pokamestov",
            "email" => "test@test.com",
        ];

        $client->request(
            'POST',
            '/api/v1/consumers',
            [],
            [],
            [],
            json_encode($consumer)
        );

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $newConsumer = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $newConsumer);
        unset($newConsumer['id']);
        $this->assertEquals($consumer, $newConsumer);
    }

    public function testConsumerNotFound()
    {
        $client = self::createClient([], ['CONTENT_TYPE' => 'application/json']);

        $client->request(
            'GET',
            '/api/v1/consumers/625279e0-230b-4179-b339-bd091bf27a77'
        );

        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
        $newConsumer = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $newConsumer);
        $this->assertEquals('Consumer not found!', $newConsumer['message']);
    }

    public function testConsumerExists()
    {
        $client = self::createClient([], ['CONTENT_TYPE' => 'application/json']);

        $client->request(
            'GET',
            '/api/v1/consumers/aaa279e0-230b-4179-b339-bd091bf27a77'
        );

        $consumer = [
            "id" => "aaa279e0-230b-4179-b339-bd091bf27a77",
            "username" => "Test",
            "firstName" => "Test",
            "lastName" => "Test",
            "email" => "test@test.com",
        ];

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $newConsumer = json_decode($response->getContent(), true);
        $this->assertEquals($consumer, $newConsumer);
    }
}
