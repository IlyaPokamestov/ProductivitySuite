<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\CommandHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\RemoveAllTasksInList;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository\TaskRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\ListId;

/**
 * Class RemoveAllTasksInListCommandHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler
 */
class RemoveAllTasksInListCommandHandler implements CommandHandlerInterface
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
     * @param RemoveAllTasksInList $removeTasks
     */
    public function __invoke(RemoveAllTasksInList $removeTasks): void
    {
        $this->taskRepository->removeByListId(new ListId($removeTasks->getId()));
    }
}
