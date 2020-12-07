<?php declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\IDMS\Unit\Application;

use IlyaPokamestov\ProductivitySuite\IDMS\Application\Command\RegisterConsumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\RegistrationSaga;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Consumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\ConsumerId;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\ConsumerRepository;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class RegistrationSagaTest extends TestCase
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

        $id = ConsumerId::next();

        $handler = new RegistrationSaga($repository);
        $this->assertEquals($id, $handler->initiateRegistration($command));
    }
}
