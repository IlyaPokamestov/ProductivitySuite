<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Application\Command\Task;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\RemoveTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\RemoveTaskHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskRepository;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class RemoveTaskHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testTaskRemove()
    {
        $task = \Mockery::mock(Task::class);
        $task->shouldReceive('remove')
            ->withNoArgs()
            ->andReturnNull();

        $repository = \Mockery::mock(TaskRepository::class);
        $repository->shouldReceive('findById')
            ->with(\Mockery::type(TaskId::class))
            ->andReturn($task);
        $repository->shouldReceive('save')
            ->with(\Mockery::type(Task::class))
            ->andReturnNull();

        $command = new RemoveTask(
            Uuid::uuid4()->toString(),
        );

        $handler = new RemoveTaskHandler($repository);
        $handler($command);
    }
}
