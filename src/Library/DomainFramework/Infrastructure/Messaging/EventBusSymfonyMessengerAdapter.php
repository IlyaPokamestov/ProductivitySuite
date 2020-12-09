<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Messaging;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\EventBusInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\EventInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class EventBusSymfonyMessengerAdapter
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Messaging
 */
class EventBusSymfonyMessengerAdapter implements EventBusInterface
{
    /** @var MessageBusInterface */
    private MessageBusInterface $messageBus;

    /**
     * EventBusSymfonyMessengerAdapter constructor.
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /** {@inheritDoc} */
    public function dispatch(EventInterface $event): void
    {
        $this->messageBus->dispatch($event);
    }
}
