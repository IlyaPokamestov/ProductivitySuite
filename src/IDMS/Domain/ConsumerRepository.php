<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Domain;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;

/**
 * Interface ConsumerRepository
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Domain
 */
interface ConsumerRepository
{
    /**
     * Save consumer.
     *
     * @param Consumer $consumer
     */
    public function save(Consumer $consumer): void;

    /**
     * @param ConsumerId $id
     * @return Consumer
     * @EntityNotFoundException
     */
    public function findConsumerById(ConsumerId $id): Consumer;
}
