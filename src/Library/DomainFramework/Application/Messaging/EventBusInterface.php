<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\EventInterface;

/**
 * Interface EventBusInterface
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging
 */
interface EventBusInterface extends MessageBusInterface
{
    /**
     * Dispatch event to event bus.
     *
     * @param EventInterface $event
     */
    public function dispatch(EventInterface $event): void;
}
