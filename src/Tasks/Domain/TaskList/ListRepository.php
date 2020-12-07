<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;

/**
 * Interface ListRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList
 */
interface ListRepository
{
    /**
     * Save list.
     *
     * @param TaskList $list
     */
    public function save(TaskList $list): void;

    /**
     * @param ListId $id
     * @return TaskList
     * @throws EntityNotFoundException
     */
    public function findListById(ListId $id): TaskList;
}
