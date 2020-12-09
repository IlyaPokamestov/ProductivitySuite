<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Application\Command\Task;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\MoveTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler\MoveTaskCommandHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Policy\OwnershipPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository\TaskRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository\ListRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\TaskList;
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
        $listRepository->shouldReceive('findById')
            ->with(\Mockery::type(ListId::class))
            ->andReturn($list);

        $command = new \IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\MoveTask(
            Uuid::uuid4()->toString(),
            Uuid::uuid4()->toString(),
        );

        $handler = new \IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler\MoveTaskCommandHandler($repository, $policy, $listRepository);
        $handler($command);
    }
}
