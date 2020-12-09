<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\IDMS\Unit\Application\Query;

use IlyaPokamestov\ProductivitySuite\IDMS\Application\ReadModel\ConsumerReadModel;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\QueryHandler\FindConsumerByIdQueryHandler;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\ReadModel\ConsumerReadRepository;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\Query\FindConsumerById;
use PHPUnit\Framework\TestCase;

class ConsumerHandlerTest extends TestCase
{
    public function testFindById()
    {
        $consumerDto = \Mockery::mock(\IlyaPokamestov\ProductivitySuite\IDMS\Application\ReadModel\ConsumerReadModel::class);
        $repository = \Mockery::mock(ConsumerReadRepository::class);
        $repository->shouldReceive('findById')
            ->withAnyArgs()
            ->andReturn($consumerDto);

        $handler = new FindConsumerByIdQueryHandler($repository);
        $this->assertEquals($consumerDto, $handler(new FindConsumerById('123')));
    }
}
