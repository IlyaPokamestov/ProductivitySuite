<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Application\Command\Task;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\RemoveTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler\RemoveTaskCommandHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Policy\OwnershipPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository\TaskRepository;
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

        $repository = \Mockery::mock(\IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository\TaskRepository::class);
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

        $command = new RemoveTask(
            Uuid::uuid4()->toString(),
        );

        $handler = new \IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler\RemoveTaskCommandHandler($repository, $policy);
        $handler($command);
    }
}
