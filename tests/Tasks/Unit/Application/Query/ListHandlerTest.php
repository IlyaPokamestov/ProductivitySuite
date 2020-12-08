<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Application\Query;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\FindById;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\FindByHandler;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\TaskList;
use IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine\ListRepository;
use PHPUnit\Framework\TestCase;

class ListHandlerTest extends TestCase
{
    public function testFindById()
    {
        //TODO: Rewrite after I found a solution for view models.
        $this->markTestSkipped();

        $listDto = \Mockery::mock(TaskList::class);
        $repository = \Mockery::mock(ListRepository::class);
        $repository->shouldReceive('findTaskById')
            ->withAnyArgs()
            ->andReturn($listDto);

        $handler = new FindByHandler($repository);
        $this->assertEquals($listDto, $handler->findById(new FindById('123')));
    }
}
