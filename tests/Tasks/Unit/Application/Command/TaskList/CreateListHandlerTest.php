<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Application\Command\TaskList;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\CreateTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler\CreateTaskCommandHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\CreateList;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler\CreateListCommandHandler;
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

class CreateListHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testListCreation()
    {
        $repository = \Mockery::mock(ListRepository::class);
        $repository->shouldReceive('save')
            ->with(\Mockery::type(TaskList::class))
            ->andReturnNull();

        $policy = \Mockery::mock(OwnerRegisteredPolicy::class);
        $policy->shouldReceive('verify')
            ->with(\Mockery::type(OwnerId::class))
            ->andReturnNull();

        $command = new \IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\CreateList(
            'Default',
            Uuid::uuid4()->toString()
        );

        $id = ListId::next();
        $handler = new CreateListCommandHandler($repository, $policy);
        $this->assertEquals($id, $handler($command));
    }
}
