<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Domain\TaskList;

use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\OwnerId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListCreated;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListRemoved;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\TaskList;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class TaskListTest extends TestCase
{
    public function testCreation()
    {
        $id = Uuid::uuid4()->toString();
        $ownerId = Uuid::uuid4()->toString();
        $list = TaskList::create(new ListId($id), 'Default', new OwnerId($ownerId));

        $this->assertInstanceOf(TaskList::class, $list);
        $events = $list->events();
        $this->assertCount(1, $events);
        /** @var ListCreated $event */
        $event = $events[0];
        $this->assertInstanceOf(ListCreated::class, $event);

        $this->assertEquals($id, $event->getId());
        $this->assertEquals('Default', $event->getName());
        $this->assertEquals($ownerId, $event->getOwnerId());
    }

    public function testRemoval()
    {
        $id = Uuid::uuid4()->toString();
        $ownerId = Uuid::uuid4()->toString();
        $list = TaskList::create(new ListId($id), 'Default', new OwnerId($ownerId));

        $this->assertInstanceOf(TaskList::class, $list);

        $list->remove();

        $events = $list->events();
        $this->assertCount(2, $events);
        /** @var ListRemoved $event */
        $event = $events[1];
        $this->assertInstanceOf(ListRemoved::class, $event);

        $this->assertEquals($id, $event->getId());
    }
}
