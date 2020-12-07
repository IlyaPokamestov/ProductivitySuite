<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Application\Command\Task;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\MoveTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\MoveTaskHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Policy\OwnershipPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\TaskList;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class MoveTaskHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testTaskMove()
    {
        $task = \Mockery::mock(Task::class);
        $task->shouldReceive('move')
            ->with(\Mockery::type(ListId::class))
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
        $policy->shouldReceive('verify')
            ->with(\Mockery::type(TaskList::class))
            ->andReturnNull();

        $list = \Mockery::mock(TaskList::class);
        $listRepository = \Mockery::mock(ListRepository::class);
        $listRepository->shouldReceive('findListById')
            ->with(\Mockery::type(ListId::class))
            ->andReturn($list);

        $command = new MoveTask(
            Uuid::uuid4()->toString(),
            Uuid::uuid4()->toString(),
        );

        $handler = new MoveTaskHandler($repository, $policy, $listRepository);
        $handler($command);
    }
}
