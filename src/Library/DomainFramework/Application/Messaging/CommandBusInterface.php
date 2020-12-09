<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging;

/**
 * Interface CommandBusInterface
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging
 */
interface CommandBusInterface extends MessageBusInterface
{
    /**
     * Sends command to command bus.
     *
     * @param CommandInterface $command
     */
    public function command(CommandInterface $command): void;
}
