<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain;

/**
 * Trait EventRecorderTrait
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain
 */
trait EventRecorderTrait
{
    /**
     * Holds a collection of domain events recorded by aggregate root.
     *
     * @var EventInterface[]
     */
    protected array $events = [];

    /**
     * Record domain event.
     *
     * @param EventInterface $event
     */
    public function record(EventInterface $event): void
    {
        $this->events[] = $event;
    }

    /**
     * Returns collected events.
     * We need this method to be able to extracts events from the aggregate root and send to event bus.
     *
     * @return EventInterface[]
     */
    public function events(): array
    {
        $events = $this->events;

        $this->events = [];

        return $events;
    }
}
