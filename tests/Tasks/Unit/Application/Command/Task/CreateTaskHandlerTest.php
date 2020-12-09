<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Application\Command\Task;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\CreateTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler\CreateTaskCommandHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Owner\OwnerId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Policy\OwnerRegisteredPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository\TaskRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository\ListRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\TaskList;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateTaskHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testTaskCreation()
    {
        $repository = \Mockery::mock(\IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository\TaskRepository::class);
        $repository->shouldReceive('save')
            ->with(\Mockery::type(Task::class))
            ->andReturnNull();

        $policy = \Mockery::mock(OwnerRegisteredPolicy::class);
        $policy->shouldReceive('verify')
            ->with(\Mockery::type(OwnerId::class))
            ->andReturnNull();

        $list = \Mockery::mock(TaskList::class);
        $listRepository = \Mockery::mock(ListRepository::class);
        $listRepository->shouldReceive('findById')
            ->with(\Mockery::type(ListId::class))
            ->andReturn($list);

        $command = new \IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\CreateTask(
            'Do that!',
            'now!',
            Uuid::uuid4()->toString(),
            Uuid::uuid4()->toString(),
        );

        $id = ListId::next();
        $handler = new CreateTaskCommandHandler($repository, $policy, $listRepository);
        $this->assertEquals($id, $handler($command));
    }
}
