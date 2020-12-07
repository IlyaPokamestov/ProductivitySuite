<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\IDMS\Unit\Application\Query;

use IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\Consumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\ConsumerHandler;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\ConsumerRepository;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\FindById;
use PHPUnit\Framework\TestCase;

class ConsumerHandlerTest extends TestCase
{
    public function testFindById()
    {
        $consumerDto = \Mockery::mock(Consumer::class);
        $repository = \Mockery::mock(ConsumerRepository::class);
        $repository->shouldReceive('findById')
            ->withAnyArgs()
            ->andReturn($consumerDto);

        $handler = new ConsumerHandler($repository);
        $this->assertEquals($consumerDto, $handler(new FindById('123')));
    }
}
