<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Application\Query;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\FindListById;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\QueryHandler\FindByListByIdQueryHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel\ListReadRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel\TaskListReadModel;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Policy\OwnershipPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Task;
use PHPUnit\Framework\TestCase;

class FindByIdHandlerTest extends TestCase
{
    public function testFindById()
    {
        $listDto = \Mockery::mock(TaskListReadModel::class);
        $aggregate = \Mockery::mock(\IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\TaskList::class);
        $repository = \Mockery::mock(ListReadRepository::class);
        $repository->shouldReceive('findAggregateById')
            ->withAnyArgs()
            ->andReturn($aggregate);

        $repository->shouldReceive('findById')
            ->withAnyArgs()
            ->andReturn($listDto);

        $policy = \Mockery::mock(OwnershipPolicy::class);
        $policy->shouldReceive('verify')
            ->with(\Mockery::type(\IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\TaskList::class))
            ->andReturnNull();

        $handler = new FindByListByIdQueryHandler($repository, $policy);
        $this->assertEquals($listDto, $handler(new FindListById('123')));
    }
}
