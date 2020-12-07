<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Application\Query;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task\FindById;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task\TaskHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task\TaskRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task\Task;
use PHPUnit\Framework\TestCase;

class TaskHandlerTest extends TestCase
{
    public function testFindById()
    {
        $taskDto = \Mockery::mock(Task::class);
        $repository = \Mockery::mock(TaskRepository::class);
        $repository->shouldReceive('findTaskById')
            ->withAnyArgs()
            ->andReturn($taskDto);

        $handler = new TaskHandler($repository);
        $this->assertEquals($taskDto, $handler->findById(new FindById('123')));
    }
}
