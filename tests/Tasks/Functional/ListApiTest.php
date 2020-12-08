<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ListApiTest extends WebTestCase
{
    /** @var \Symfony\Bundle\FrameworkBundle\KernelBrowser */
    protected static $client = null;

    private function getMyClient()
    {
        if ($this::$client) {
            return $this::$client;
        }

        return $this::$client = self::createClient(
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_X-AUTHORIZED-CONSUMER-ID' => '8086733f-7cdd-45ef-9cc7-05fc132fd993'
            ]
        );
    }

    public function testCreateList()
    {
        $client = $this->getMyClient();

        $list = [
            "name" => "Test",
            "ownerId" => '8086733f-7cdd-45ef-9cc7-05fc132fd993'
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
        $this->assertEquals("Test", $newConsumer['name']);
    }

    public function testAllLists()
    {
        $client = $this->getMyClient();
        $client->request(
            'GET',
            '/api/v1/lists'
        );

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $lists = json_decode($response->getContent(), true);
        $this->assertCount(2, $lists);
    }

    public function testListRemove()
    {
        $client = $this->getMyClient();

        $client->request(
            'DELETE',
            '/api/v1/lists/fd0e060c-2d15-4432-a463-12e5511fe6cc'
        );

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        $client->request(
            'GET',
            '/api/v1/lists'
        );

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $lists = json_decode($response->getContent(), true);
        $this->assertCount(1, $lists);
    }
}
