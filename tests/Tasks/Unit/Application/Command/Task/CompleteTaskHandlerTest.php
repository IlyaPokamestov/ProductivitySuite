<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Application\Command\Task;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\CompleteTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\CompleteTaskHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\OwnerId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Policy\OwnershipPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Description;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskRepository;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CompleteTaskHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testTaskUpdate()
    {
        $task = \Mockery::mock(Task::class);
        $task->shouldReceive('complete')
            ->withNoArgs()
            ->andReturnNull();

        $repository = \Mockery::mock(TaskRepository::class);
        $repository->shouldReceive('findById')
            ->with(\Mockery::type(TaskId::class))
            ->andReturn($task);
        $repository->shouldReceive('save')
            ->with(\Mockery::type(Task::class))
            ->andReturnNull();

        $policy = \Mockery::mock(OwnershipPolicy::class);
        $policy->shouldReceive('verify')
            ->with(\Mockery::type(Task::class))
            ->andReturnNull();

        $command = new CompleteTask(
            Uuid::uuid4()->toString(),
        );

        $handler = new CompleteTaskHandler($repository, $policy);
        $handler($command);
    }
}
