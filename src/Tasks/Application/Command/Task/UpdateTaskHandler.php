<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Description;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskRepository;

/**
 * Class UpdateTaskHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task
 */
class UpdateTaskHandler
{
    /** @var TaskRepository */
    private TaskRepository $taskRepository;

    /**
     * CreateTaskHandler constructor.
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Update task handler.
     *
     * @param UpdateTask $updateTask
     * @throws EntityNotFoundException
     */
    public function __invoke(UpdateTask $updateTask)
    {
        $task = $this->taskRepository->findById(new TaskId($updateTask->getId()));

        $task->update(new Description($updateTask->getTitle(), $updateTask->getNote()));

        $this->taskRepository->save($task);
    }
}
