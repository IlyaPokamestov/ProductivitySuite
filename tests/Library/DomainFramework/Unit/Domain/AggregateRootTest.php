<?php declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Library\DomainFramework\Unit\Domain;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\AggregateRoot;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Event;
use PHPUnit\Framework\TestCase;

final class AggregateRootTest extends TestCase
{
    public function testRecordEvent(): void
    {
        $domainEvent = \Mockery::mock(Event::class);

        $aggregate = new class extends AggregateRoot {};
        $aggregate->record($domainEvent);

        $this->assertEquals([$domainEvent], $aggregate->events());
        $this->assertEmpty($aggregate->events());
    }
}
