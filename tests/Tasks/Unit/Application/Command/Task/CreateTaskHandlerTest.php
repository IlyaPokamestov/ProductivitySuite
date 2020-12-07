<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Application\Command\Task;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\CreateTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\CreateTaskHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\OwnerId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Policy\OwnerRegisteredPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\TaskList;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateTaskHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testTaskCreation()
    {
        $repository = \Mockery::mock(TaskRepository::class);
        $repository->shouldReceive('save')
            ->with(\Mockery::type(Task::class))
            ->andReturnNull();

        $policy = \Mockery::mock(OwnerRegisteredPolicy::class);
        $policy->shouldReceive('verify')
            ->with(\Mockery::type(OwnerId::class))
            ->andReturnNull();

        $list = \Mockery::mock(TaskList::class);
        $listRepository = \Mockery::mock(ListRepository::class);
        $listRepository->shouldReceive('findListById')
            ->with(\Mockery::type(ListId::class))
            ->andReturn($list);

        $command = new CreateTask(
            'Do that!',
            'now!',
            Uuid::uuid4()->toString(),
            Uuid::uuid4()->toString(),
        );

        $id = ListId::next();
        $handler = new CreateTaskHandler($repository, $policy, $listRepository);
        $this->assertEquals($id, $handler($command));
    }
}
