<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Application\Command\Task;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\UpdateTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\UpdateTaskHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Description;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskRepository;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateTaskHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testTaskUpdate()
    {
        $task = \Mockery::mock(Task::class);
        $task->shouldReceive('update')
            ->with(\Mockery::type(Description::class))
            ->andReturnNull();

        $repository = \Mockery::mock(TaskRepository::class);
        $repository->shouldReceive('find')
            ->with(\Mockery::type(TaskId::class))
            ->andReturn($task);
        $repository->shouldReceive('save')
            ->with(\Mockery::type(Task::class))
            ->andReturnNull();

        $command = new UpdateTask(
            Uuid::uuid4()->toString(),
            'Do that!',
            '',
        );

        $handler = new UpdateTaskHandler($repository);
        $handler($command);
    }
}
