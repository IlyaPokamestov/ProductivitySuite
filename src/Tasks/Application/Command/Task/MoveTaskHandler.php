<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;

/**
 * Class MoveTaskHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task
 */
class MoveTaskHandler
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
     * Move task handler.
     *
     * @param MoveTask $moveTask
     * @throws EntityNotFoundException
     */
    public function __invoke(MoveTask $moveTask)
    {
        $task = $this->taskRepository->find(new TaskId($moveTask->getId()));

        //TODO: Check that target list exists.
        //TODO: Check that target list belongs to the same owner.
        $task->move(new ListId($moveTask->getId()));

        $this->taskRepository->save($task);
    }
}
