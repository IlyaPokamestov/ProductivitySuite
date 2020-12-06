<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Domain;

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
}
