<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;

/**
 * Interface TaskRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task
 */
interface TaskRepository
{
    /**
     * Find task by ID
     *
     * @param TaskId $id
     * @return Task
     *
     * @throws EntityNotFoundException
     */
    public function findById(TaskId $id): Task;

    /**
     * Save task.
     *
     * @param Task $task
     */
    public function save(Task $task): void;

    /**
     * Remove all tasks which belongs to list with provided ID.
     *
     * @param ListId $id
     */
    public function removeByListId(ListId $id): void;
}
