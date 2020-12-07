<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\CommandHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;

/**
 * Class RemoveListTasksHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task
 */
class RemoveListTasksHandler implements CommandHandlerInterface
{
    /** @var TaskRepository */
    private TaskRepository $taskRepository;

    /**
     * RemoveListTasksHandler constructor.
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Let's assume that we shouldn't collect the list of removed tasks.
     * And the same business rule "remove tasks in case list removed" applicable to the whole products
     * it means that all products can listen list removed event and behave on themself
     *
     * @param RemoveAllTasksWhichBelongsToList $removeTasks
     */
    public function __invoke(RemoveAllTasksWhichBelongsToList $removeTasks)
    {
        $this->taskRepository->removeByListId(new ListId($removeTasks->getId()));
    }
}
