<?php

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\EventHandler;

use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\Event\RegistrationInitiated;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\EventHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\CreateList;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\TaskList;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class OnConsumerRegistrationEventHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\EventHandler
 */
class OnConsumerRegistrationEventHandler implements EventHandlerInterface
{
    /** @var MessageBusInterface */
    private MessageBusInterface $commandBus;

    /**
     * OnConsumerRegistrationEventHandler constructor.
     * @param MessageBusInterface $commandBus
     */
    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param RegistrationInitiated $initiated
     */
    public function __invoke(RegistrationInitiated $initiated)
    {
        $this->commandBus->dispatch(new CreateList(TaskList::DEFAULT_LIST_NAME, $initiated->getId()));
    }
}
