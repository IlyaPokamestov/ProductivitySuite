<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;

/**
 * Interface TaskRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task
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
    public function findTaskById(string $id): Task;
}
