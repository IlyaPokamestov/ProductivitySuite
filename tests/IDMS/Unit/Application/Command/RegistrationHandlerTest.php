<?php declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\IDMS\Unit\Application\Command;

use IlyaPokamestov\ProductivitySuite\IDMS\Application\Command\RegisterConsumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\Command\RegistrationHandler;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Consumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\ConsumerRepository;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class RegistrationHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testRegistrationFlow()
    {
        $repository = \Mockery::mock(ConsumerRepository::class);
        $repository->shouldReceive('save')
            ->with(\Mockery::type(Consumer::class))
            ->andReturnNull();

        $command = new RegisterConsumer(
            'IlyaPokamestov',
            'Ilya',
            'Pokamestov',
            'test@test.com'
        );

        $handler = new RegistrationHandler($repository);
        $handler($command);
    }
}
