<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Application\Query;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\FindById;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\ListHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\ListRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\TaskList;
use PHPUnit\Framework\TestCase;

class ListHandlerTest extends TestCase
{
    public function testFindById()
    {
        $listDto = \Mockery::mock(TaskList::class);
        $repository = \Mockery::mock(ListRepository::class);
        $repository->shouldReceive('findById')
            ->withAnyArgs()
            ->andReturn($listDto);

        $handler = new ListHandler($repository);
        $this->assertEquals($listDto, $handler->findById(new FindById('123')));
    }
}
