<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;

/**
 * Interface ListRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList
 */
interface ListRepository
{
    /**
     * Find by id.
     *
     * @param string $id
     * @return TaskList
     * @throws EntityNotFoundException
     */
    public function findById(string $id): TaskList;
}
