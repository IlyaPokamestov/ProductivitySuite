<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\QueryHandlerInterface;

/**
 * Class TaskHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList
 */
class TaskHandler implements QueryHandlerInterface
{
    /** @var TaskRepository */
    public TaskRepository $taskRepository;

    /**
     * TaskHandler constructor.
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param FindById $findById
     * @return Task
     */
    public function __invoke(FindById $findById): Task
    {
        return $this->taskRepository->findById($findById->getId());
    }
}
