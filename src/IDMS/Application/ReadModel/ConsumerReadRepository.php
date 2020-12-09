<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Application\ReadModel;

use IlyaPokamestov\ProductivitySuite\IDMS\Application\ReadModel\ConsumerReadModel;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;

/**
 * Interface ConsumerReadRepository
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Application\ReadModel
 */
interface ConsumerReadRepository
{
    /**
     * Find consumer by id.
     *
     * @param string $id
     * @return ConsumerReadModel
     * @throws EntityNotFoundException
     */
    public function findById(string $id): ConsumerReadModel;
}
