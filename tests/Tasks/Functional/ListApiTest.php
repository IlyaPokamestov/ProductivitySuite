<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ListApiTest extends WebTestCase
{
    public function testCreateList()
    {
        $client = self::createClient([], ['CONTENT_TYPE' => 'application/json']);

        $list = [
            "name" => "Test",
        ];

        $client->request(
            'POST',
            '/api/v1/lists',
            [],
            [],
            [],
            json_encode($list)
        );

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $newConsumer = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $newConsumer);
        unset($newConsumer['id']);
        $this->assertEquals($list, $newConsumer);
    }

    public function testListNotFound()
    {
        $client = self::createClient([], ['CONTENT_TYPE' => 'application/json']);

        $client->request(
            'GET',
            '/api/v1/lists/625279e0-230b-4179-b339-bd091bf27a77'
        );

        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
        $newConsumer = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('message', $newConsumer);
        $this->assertEquals('List not found!', $newConsumer['message']);
    }

    public function testListExists()
    {
        $client = self::createClient([], ['CONTENT_TYPE' => 'application/json']);

        $client->request(
            'GET',
            '/api/v1/lists/aaa279e0-230b-4179-b339-bd091bf27a77'
        );

        $consumer = [
            "id" => "aaa279e0-230b-4179-b339-bd091bf27a77",
            "name" => "Test",
        ];

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $newConsumer = json_decode($response->getContent(), true);
        $this->assertEquals($consumer, $newConsumer);
    }
}
