<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging;

/**
 * Interface QueryBusInterface
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging
 */
interface QueryBusInterface extends MessageBusInterface
{
    /**
     * Executes query and receives result.
     *
     * @param QueryInterface $query
     * @return mixed
     */
    public function query(QueryInterface $query);
}
