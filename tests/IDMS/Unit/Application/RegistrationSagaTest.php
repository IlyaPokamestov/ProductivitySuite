<?php declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\IDMS\Unit\Application;

use IlyaPokamestov\ProductivitySuite\IDMS\Application\Command\RegisterConsumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Application\Saga\RegistrationSaga;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\Consumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Repository\ConsumerRepository;
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

        $handler = new RegistrationSaga($repository);
        $handler->initiateRegistration($command);
    }
}
