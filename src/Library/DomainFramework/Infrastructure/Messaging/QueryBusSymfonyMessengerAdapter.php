<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Messaging;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\QueryBusInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\QueryInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class QueryBusSymfonyMessengerAdapter
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Messaging
 */
class QueryBusSymfonyMessengerAdapter implements QueryBusInterface
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
    public function query(QueryInterface $query)
    {
        return $this->handle($this->messageBus, $query);
    }
}
