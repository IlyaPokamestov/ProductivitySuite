<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\CommandHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Policy\OwnershipPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListRepository;

/**
 * Class MoveTaskHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task
 */
class MoveTaskHandler implements CommandHandlerInterface
{
    /** @var TaskRepository */
    private TaskRepository $taskRepository;
    /** @var OwnershipPolicy */
    private OwnershipPolicy $ownershipPolicy;
    /** @var ListRepository */
    private ListRepository $listRepository;

    /**
     * MoveTaskHandler constructor.
     * @param TaskRepository $taskRepository
     * @param OwnershipPolicy $ownershipPolicy
     * @param ListRepository $listRepository
     */
    public function __construct(
        TaskRepository $taskRepository,
        OwnershipPolicy $ownershipPolicy,
        ListRepository $listRepository
    ) {
        $this->taskRepository = $taskRepository;
        $this->ownershipPolicy = $ownershipPolicy;
        $this->listRepository = $listRepository;
    }

    /**
     * Move task handler.
     *
     * @param MoveTask $moveTask
     * @throws EntityNotFoundException
     */
    public function __invoke(MoveTask $moveTask)
    {
        $task = $this->taskRepository->findById(new TaskId($moveTask->getId()));
        $this->ownershipPolicy->verify($task);

        $targetList = $this->listRepository->findById(new ListId($moveTask->getListId()));
        $this->ownershipPolicy->verify($targetList);

        $task->move(new ListId($moveTask->getListId()));

        $this->taskRepository->save($task);
    }
}
