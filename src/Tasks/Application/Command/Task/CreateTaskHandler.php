<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task;

use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Description;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;

/**
 * Class CreateTaskHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task
 */
class CreateTaskHandler
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
     * @param CreateTask $createTask
     */
    public function __invoke(CreateTask $createTask)
    {
        //TODO: Check that list exists.

        $task = Task::create(
            TaskId::generate(),
            new ListId($createTask->getListId()),
            new Description($createTask->getTitle(), $createTask->getNote())
        );

        $this->taskRepository->save($task);
    }
}
