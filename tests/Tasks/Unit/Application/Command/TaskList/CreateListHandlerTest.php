<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Application\Command\TaskList;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\CreateTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\CreateTaskHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\TaskList\CreateList;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\TaskList\CreateListHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\TaskList;
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

        $command = new CreateList(
            'Default',
        );

        $id = ListId::next();
        $handler = new CreateListHandler($repository);
        $this->assertEquals($id, $handler($command));
    }
}
