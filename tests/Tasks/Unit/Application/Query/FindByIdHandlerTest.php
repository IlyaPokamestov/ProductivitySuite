<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Application\Query;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\FindById;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\FindByIdHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\ListRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\TaskList;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Policy\OwnershipPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Task;
use PHPUnit\Framework\TestCase;

class FindByIdHandlerTest extends TestCase
{
    public function testFindById()
    {
        $listDto = \Mockery::mock(TaskList::class);
        $aggregate = \Mockery::mock(\IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\TaskList::class);
        $repository = \Mockery::mock(ListRepository::class);
        $repository->shouldReceive('findAggregateById')
            ->withAnyArgs()
            ->andReturn($aggregate);

        $repository->shouldReceive('findById')
            ->withAnyArgs()
            ->andReturn($listDto);

        $policy = \Mockery::mock(OwnershipPolicy::class);
        $policy->shouldReceive('verify')
            ->with(\Mockery::type(\IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\TaskList::class))
            ->andReturnNull();

        $handler = new FindByIdHandler($repository, $policy);
        $this->assertEquals($listDto, $handler(new FindById('123')));
    }
}
