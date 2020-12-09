<?php

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\EventHandler;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\EventHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\RemoveAllTasksInList;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\Event\ListRemoved;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class OnListRemovedEventHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\EventHandler
 */
class OnListRemovedEventHandler implements EventHandlerInterface
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
     * @param ListRemoved $listRemoved
     */
    public function __invoke(ListRemoved $listRemoved)
    {
        $this->commandBus->dispatch(new RemoveAllTasksInList($listRemoved->getId()));
    }
}
