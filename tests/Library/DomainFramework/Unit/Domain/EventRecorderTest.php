<?php declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Library\DomainFramework\Unit\Domain;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\EventRecorderInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\EventRecorderTrait;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\EventInterface;
use PHPUnit\Framework\TestCase;

final class EventRecorderTest extends TestCase
{
    public function testRecordEvent(): void
    {
        $domainEvent = \Mockery::mock(EventInterface::class);

        $aggregate = new class implements EventRecorderInterface {
            use EventRecorderTrait;
        };
        $aggregate->record($domainEvent);

        $this->assertEquals([$domainEvent], $aggregate->events());
        $this->assertEmpty($aggregate->events());
    }
}
