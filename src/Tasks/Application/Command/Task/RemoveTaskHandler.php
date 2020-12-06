<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskRepository;

/**
 * Class RemoveTaskHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task
 */
class RemoveTaskHandler
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
     * Remove task handler.
     *
     * @param RemoveTask $removeTask
     * @throws EntityNotFoundException
     */
    public function __invoke(RemoveTask $removeTask)
    {
        $task = $this->taskRepository->find(new TaskId($removeTask->getId()));

        $task->remove();

        $this->taskRepository->save($task);
    }
}
