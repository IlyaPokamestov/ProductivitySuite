<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Domain\Task;

use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Description;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Events\TaskCreated;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Events\TaskMoved;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Events\TaskRemoved;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Events\TaskUpdated;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class TaskTest extends TestCase
{
    public function testCreation()
    {
        /**
         * @var Task $task
         * @var string $id
         * @var string $listId
         */
        [$task, $id, $listId] = $this->taskFixture();

        $this->assertInstanceOf(Task::class, $task);
        $events = $task->events();
        $this->assertCount(1, $events);
        /** @var TaskCreated $event */
        $event = $events[0];
        $this->assertInstanceOf(TaskCreated::class, $event);

        $this->assertEquals($id, $event->getId());
        $this->assertEquals($listId, $event->getListId());
        $this->assertEquals('Do that!',  $event->getTitle());
        $this->assertEquals('now!', $event->getNote());
    }

    public function testRemoval()
    {
        /**
         * @var Task $task
         * @var string $id
         */
        [$task, $id] = $this->taskFixture();

        $this->assertInstanceOf(Task::class, $task);

        $task->remove();

        $events = $task->events();
        $this->assertCount(2, $events);
        /** @var TaskRemoved $event */
        $event = $events[1];
        $this->assertInstanceOf(TaskRemoved::class, $event);

        $this->assertEquals($id, $event->getId());
    }

    public function testUpdated()
    {
        /**
         * @var Task $task
         * @var string $id
         */
        [$task, $id] = $this->taskFixture();

        $this->assertInstanceOf(Task::class, $task);

        $task->update(new Description('Updated'));

        $events = $task->events();
        $this->assertCount(2, $events);
        /** @var TaskUpdated $event */
        $event = $events[1];
        $this->assertInstanceOf(TaskUpdated::class, $event);

        $this->assertEquals($id, $event->getId());
        $this->assertEquals('Updated', $event->getTitle());
        $this->assertEquals('', $event->getNote());
    }

    public function testMoved()
    {
        /**
         * @var Task $task
         * @var string $id
         * @var string $listId
         */
        [$task, $id, $listId] = $this->taskFixture();

        $this->assertInstanceOf(Task::class, $task);

        $newListId = Uuid::uuid4()->toString();
        $task->move(new ListId($newListId));

        $events = $task->events();
        $this->assertCount(2, $events);
        /** @var TaskMoved $event */
        $event = $events[1];
        $this->assertInstanceOf(TaskMoved::class, $event);

        $this->assertEquals($id, $event->getId());
        $this->assertEquals($newListId, $event->getListId());
        $this->assertNotEquals($newListId, $listId);
    }

    /** @return array */
    public function taskFixture(): array
    {
        $id = Uuid::uuid4()->toString();
        $listId = Uuid::uuid4()->toString();

        return [
            Task::create(new TaskId($id), new ListId($listId), new Description('Do that!', 'now!')),
            $id,
            $listId
        ];
    }
}
