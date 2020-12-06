<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain;

/**
 * Class AggregateRoot
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain
 *
 * Base class for aggregate roots.
 * As an alternative to the base class we can use static collector,
 * but in this case you need to deal with global state which is not what I'm prefer to do.
 */
abstract class AggregateRoot
{
    /**
     * Holds a collection of domain events recorded by aggregate root.
     *
     * @var Event[]
     */
    protected array $events = [];

    /**
     * Record domain event.
     *
     * @param Event $event
     */
    public function record(Event $event): void
    {
        $this->events[] = $event;
    }

    /**
     * Returns collected events.
     * We need this method to be able to extracts events from the aggregate root and send to event bus.
     *
     * @return Event[]
     */
    public function events(): array
    {
        $events = $this->events;

        $this->events = [];

        return $events;
    }
}
