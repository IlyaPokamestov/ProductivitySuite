<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Messaging;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\CommandBusInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\QueryBusInterface;

/**
 * Trait CqrsControllerTrait
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Messaging
 */
trait CqrsControllerTrait
{
    /** @var CommandBusInterface */
    private CommandBusInterface $commandBus;
    /** @var QueryBusInterface */
    private QueryBusInterface $queryBus;

    /**
     * TaskController constructor.
     * @param CommandBusInterface $commandBus
     * @param QueryBusInterface $queryBus
     */
    public function __construct(CommandBusInterface $commandBus, QueryBusInterface $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }
}
