<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;

/**
 * Interface TaskRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query
 */
interface TaskRepository
{
    /**
     * Find by id.
     *
     * @param string $id
     * @return Task
     * @throws EntityNotFoundException
     */
    public function findById(string $id): Task;
}
