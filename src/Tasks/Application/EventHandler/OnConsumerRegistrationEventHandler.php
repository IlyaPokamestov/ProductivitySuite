<?php

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\EventHandler;

use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\Event\RegistrationInitiated;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\CommandBusInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\EventHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\CreateList;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\TaskList;

/**
 * Class OnConsumerRegistrationEventHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\EventHandler
 */
class OnConsumerRegistrationEventHandler implements EventHandlerInterface
{
    /** @var CommandBusInterface */
    private CommandBusInterface $commandBus;

    /**
     * OnConsumerRegistrationEventHandler constructor.
     * @param CommandBusInterface $commandBus
     */
    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param RegistrationInitiated $initiated
     */
    public function __invoke(RegistrationInitiated $initiated)
    {
        $this->commandBus->command(new CreateList(TaskList::DEFAULT_LIST_NAME, $initiated->getId()));
    }
}
