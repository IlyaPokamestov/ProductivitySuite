<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskApiTest extends WebTestCase
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

    public function testCreateTask()
    {
        $client = $this->getMyClient();

        $task = [
            "title" => "Buy coffee",
            "note" => "",
            "listId" => "fd0e060c-2d15-4432-a463-12e5511fe6cc",
            "ownerId" => '8086733f-7cdd-45ef-9cc7-05fc132fd993',
        ];

        $client->request(
            'POST',
            '/api/v1/tasks',
            [],
            [],
            [],
            json_encode($task)
        );

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $newConsumer = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $newConsumer);
        unset($newConsumer['id']);
        $this->assertEquals($task['title'], $newConsumer['title']);
    }

    public function testComplete()
    {
        $client = $this->getMyClient();

        $completed = [
            "completed" => true,
        ];

        $client->request(
            'PATCH',
            '/api/v1/tasks/0e4fea85-c28b-45dc-8df2-ca9d2c4110b3',
            [],
            [],
            [],
            json_encode($completed)
        );

        $task = [
            "id" => "0e4fea85-c28b-45dc-8df2-ca9d2c4110b3",
            "title" => "Task#0",
            "listId" => "fd0e060c-2d15-4432-a463-12e5511fe6cc"
        ];

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $newConsumer = json_decode($response->getContent(), true);
        $this->assertEquals($task, $newConsumer);
    }

    public function testDelete()
    {
        $client = $this->getMyClient();

        $client->request(
            'DELETE',
            '/api/v1/tasks/0e4fea85-c28b-45dc-8df2-ca9d2c4110b3'
        );

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $newConsumer = json_decode($response->getContent(), true);
        $this->assertEquals([], $newConsumer);
    }
}
