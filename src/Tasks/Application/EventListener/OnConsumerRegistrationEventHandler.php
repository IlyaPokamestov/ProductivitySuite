<?php

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\EventListener;

use IlyaPokamestov\ProductivitySuite\IDMS\Domain\RegistrationInitiated;
use IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\MessageBus\EventHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\TaskList\CreateList;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\TaskList;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class OnConsumerRegistration
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\EventListener
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
