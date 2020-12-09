<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Application\Command\Task;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\CompleteTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler\CompleteTaskCommandHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Owner\OwnerId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Policy\OwnershipPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Description;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository\TaskRepository;
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

        $handler = new CompleteTaskCommandHandler($repository, $policy);
        $handler($command);
    }
}
