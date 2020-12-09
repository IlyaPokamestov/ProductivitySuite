<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Application\Query;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\FindTaskById;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\QueryHandler\FindTaskByIdQueryHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel\TaskReadRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel\TaskReadModel;
use PHPUnit\Framework\TestCase;

class TaskHandlerTest extends TestCase
{
    public function testFindById()
    {
        $taskDto = \Mockery::mock(TaskReadModel::class);
        $repository = \Mockery::mock(TaskReadRepository::class);
        $repository->shouldReceive('findById')
            ->withAnyArgs()
            ->andReturn($taskDto);

        $handler = new FindTaskByIdQueryHandler($repository);
        $this->assertEquals($taskDto, $handler(new FindTaskById('123')));
    }
}
