<?php declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\IDMS\Unit\Domain;

use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Consumer;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\ConsumerId;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\RegistrationInitiated;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Email;
use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Name;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ConsumerTest extends TestCase
{
    public function testRegisteration(): void
    {
        $id = Uuid::uuid4()->toString();
        $consumer = Consumer::register(
            new ConsumerId($id),
            new Name('IlyaPokamestov', 'Ilya', 'Pokamestov'),
            new Email('test@test.com')
        );

        $this->assertInstanceOf(Consumer::class, $consumer);
        $events = $consumer->events();
        $this->assertCount(1, $events);
        /** @var RegistrationInitiated $event */
        $event = $events[0];
        $this->assertInstanceOf(RegistrationInitiated::class, $event);

        $this->assertEquals($id, $event->getId());
        $this->assertEquals('IlyaPokamestov', $event->getUsername());
        $this->assertEquals('Ilya', $event->getFirstName());
        $this->assertEquals( 'Pokamestov', $event->getLastName());
        $this->assertEquals( 'test@test.com', $event->getEmail());
    }
}
