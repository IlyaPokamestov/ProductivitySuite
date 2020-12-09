<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\CommandHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\MoveTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Policy\OwnershipPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository\TaskRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository\ListRepository;

/**
 * Class MoveTaskCommandHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler
 */
class MoveTaskCommandHandler implements CommandHandlerInterface
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
    public function __invoke(MoveTask $moveTask): void
    {
        $task = $this->taskRepository->findById(new TaskId($moveTask->getId()));
        $this->ownershipPolicy->verify($task);

        $targetList = $this->listRepository->findById(new ListId($moveTask->getListId()));
        $this->ownershipPolicy->verify($targetList);

        $task->move(new ListId($moveTask->getListId()));

        $this->taskRepository->save($task);
    }
}
