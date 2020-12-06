<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Application\Task;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\CreateTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\CreateTaskHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskRepository;
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

        $command = new CreateTask(
            'Do that!',
            'now!',
            Uuid::uuid4()->toString(),
        );

        $handler = new CreateTaskHandler($repository);
        $handler($command);
    }
}
