<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Application\Query;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;

/**
 * Interface ConsumerRepository
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Application\Query
 *
 * Read model repository.
 */
interface ConsumerRepository
{
    /**
     * Find consumer by id.
     *
     * @param string $id
     * @return Consumer
     * @throws EntityNotFoundException
     */
    public function findById(string $id): Consumer;
}
