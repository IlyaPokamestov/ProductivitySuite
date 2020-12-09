<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\TaskList;

/**
 * Interface ListRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository
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
    public function findById(ListId $id): TaskList;
}
