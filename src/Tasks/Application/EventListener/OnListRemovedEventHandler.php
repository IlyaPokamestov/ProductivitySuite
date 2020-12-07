<?php

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\EventListener;

use IlyaPokamestov\ProductivitySuite\IDMS\Domain\RegistrationInitiated;
use IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\MessageBus\EventHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task\RemoveAllTasksWhichBelongsToList;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\TaskList\CreateList;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListRemoved;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\TaskList;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class OnListRemovedEventHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\EventListener
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
        $this->commandBus->dispatch(new RemoveAllTasksWhichBelongsToList($listRemoved->getId()));
    }
}
