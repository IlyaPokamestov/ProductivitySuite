<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure;

use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\EventBusInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\EventRecorderInterface;

/**
 * Class DoctrineDomainEventsCollector
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure
 */
class DoctrineDomainEventsCollector implements EventSubscriberInterface
{
    /**
     * Map in which all aggregate root will be collected.
     * During one transaction / command execution it can be multiple aggregates involved.
     * With this collector we will track and collect them in this map.
     *
     * @var EventRecorderInterface[]
     */
    private array $aggregateRoots = [];

    /** @var EventBusInterface */
    private EventBusInterface $eventBus;

    /**
     * DoctrineDomainEventsCollector constructor.
     * @param EventBusInterface $eventBus
     */
    public function __construct(EventBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
     * Subscribe on Doctrine lifecycle events.
     *
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove,
            Events::postFlush,
        ];
    }

    /** @param LifecycleEventArgs $args */
    public function postRemove(LifecycleEventArgs $args): void
    {
        $this->collectAggregateRoots($args);
    }

    /** @param LifecycleEventArgs $args */
    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->collectAggregateRoots($args);
    }

    /** @param LifecycleEventArgs $args */
    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->collectAggregateRoots($args);
    }

    /** @param PostFlushEventArgs $args */
    public function postFlush(PostFlushEventArgs $args): void
    {
        foreach ($this->aggregateRoots as $entity) {
            foreach ($entity->events() as $event) {
                $this->eventBus->dispatch($event);
            }
        }
    }

    /**
     * Add aggregate to map in case it implements AggregateRoot interface.
     *
     * @param LifecycleEventArgs $args
     */
    private function collectAggregateRoots(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        if ($entity instanceof EventRecorderInterface) {
            $this->aggregateRoots[] = $entity;
        }
    }
}
