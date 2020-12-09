<?php declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Library\DomainFramework\Unit\Infrastructure;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\EventBusInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\EventRecorderInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\EventRecorderTrait;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\EventInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\DoctrineDomainEventsCollector;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;

/**
 * Class DoctrineDomainEventsCollectorTest
 * @package IlyaPokamestov\ProductivitySuite\Tests\Library\DomainFramework\Infrastructure
 */
class DoctrineDomainEventsCollectorTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testWhichEventsTracked()
    {
        $bus = \Mockery::mock(EventBusInterface::class);
        $bus->shouldNotHaveBeenCalled();

        $collector = new DoctrineDomainEventsCollector($bus);

        $this->assertEquals([
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove,
            Events::postFlush,
        ], $collector->getSubscribedEvents());
    }

    public function testPostPersistEventsPublishing()
    {
        [$bus, $aggregateRoot, $lifecycleEvent, $postFlushEventArgs] = $this->mocksToTestEvents();

        $collector = new DoctrineDomainEventsCollector($bus);

        $collector->postPersist($lifecycleEvent);
        $collector->postFlush($postFlushEventArgs);

        $this->assertEmpty($aggregateRoot->events());
    }

    public function testPostUpdateEventsPublishing()
    {
        [$bus, $aggregateRoot, $lifecycleEvent, $postFlushEventArgs] = $this->mocksToTestEvents();

        $collector = new DoctrineDomainEventsCollector($bus);

        $collector->postUpdate($lifecycleEvent);
        $collector->postFlush($postFlushEventArgs);

        $this->assertEmpty($aggregateRoot->events());
    }

    public function testPostRemoveEventsPublishing()
    {
        [$bus, $aggregateRoot, $lifecycleEvent, $postFlushEventArgs] = $this->mocksToTestEvents();

        $collector = new DoctrineDomainEventsCollector($bus);

        $collector->postRemove($lifecycleEvent);
        $collector->postFlush($postFlushEventArgs);

        $this->assertEmpty($aggregateRoot->events());
    }

    private function mocksToTestEvents()
    {
        $domainEvent = \Mockery::mock(EventInterface::class);

        $bus = \Mockery::mock(EventBusInterface::class);
        $bus->shouldReceive('dispatch')->with($domainEvent)->andReturn(new Envelope($domainEvent));

        $aggregateRoot = new class([$domainEvent]) implements EventRecorderInterface {
            use EventRecorderTrait;

            public function __construct(array $events)
            {
                $this->events = $events;
            }
        };

        $lifecycleEvent = \Mockery::mock(LifecycleEventArgs::class);
        $lifecycleEvent->shouldReceive('getEntity')->andReturn($aggregateRoot);

        $postFlushEventArgs = \Mockery::mock(PostFlushEventArgs::class);

        return [
            $bus,
            $aggregateRoot,
            $lifecycleEvent,
            $postFlushEventArgs,
        ];
    }
}
