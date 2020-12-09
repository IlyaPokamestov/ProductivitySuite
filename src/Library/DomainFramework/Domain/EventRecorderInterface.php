<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain;

/**
 * Interface EventRecorderInterface
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain
 */
interface EventRecorderInterface
{
    /**
     * Record domain event.
     *
     * @param EventInterface $event
     */
    public function record(EventInterface $event): void;

    /**
     * Returns collected events.
     * We need this method to be able to extracts events from the aggregate root and send to event bus.
     *
     * @return EventInterface[]
     */
    public function events(): array;
}
