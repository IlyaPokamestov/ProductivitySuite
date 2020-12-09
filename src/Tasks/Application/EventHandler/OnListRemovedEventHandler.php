<?php

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\EventHandler;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\CommandBusInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\EventHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\RemoveAllTasksInList;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\Event\ListRemoved;

/**
 * Class OnListRemovedEventHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\EventHandler
 */
class OnListRemovedEventHandler implements EventHandlerInterface
{
    /** @var CommandBusInterface */
    private CommandBusInterface $commandBus;

    /**
     * OnListRemovedEventHandler constructor.
     * @param CommandBusInterface $commandBus
     */
    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param ListRemoved $listRemoved
     */
    public function __invoke(ListRemoved $listRemoved)
    {
        $this->commandBus->command(new RemoveAllTasksInList($listRemoved->getId()));
    }
}
