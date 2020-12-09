<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Messaging;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\CommandBusInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\CommandInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class CommandBusSymfonyMessengerAdapter
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Messaging
 */
class CommandBusSymfonyMessengerAdapter implements CommandBusInterface
{
    use MessengerHandleTrait;

    /** @var MessageBusInterface */
    private MessageBusInterface $messageBus;

    /**
     * CommandBusSymfonyMessengerAdapter constructor.
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /** {@inheritDoc} */
    public function command(CommandInterface $command): void
    {
        $this->handle($this->messageBus, $command);
    }
}
