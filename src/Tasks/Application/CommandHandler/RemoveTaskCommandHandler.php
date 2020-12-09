<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\CommandHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\RemoveTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Exception\OwnershipMismatchException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Policy\OwnershipPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository\TaskRepository;

/**
 * Class RemoveTaskCommandHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler
 */
class RemoveTaskCommandHandler implements CommandHandlerInterface
{
    /** @var TaskRepository */
    private TaskRepository $taskRepository;
    /** @var OwnershipPolicy */
    private OwnershipPolicy $ownershipPolicy;

    /**
     * RemoveTaskHandler constructor.
     * @param TaskRepository $taskRepository
     * @param OwnershipPolicy $ownershipPolicy
     */
    public function __construct(TaskRepository $taskRepository, OwnershipPolicy $ownershipPolicy)
    {
        $this->taskRepository = $taskRepository;
        $this->ownershipPolicy = $ownershipPolicy;
    }

    /**
     * Remove task handler.
     *
     * @param RemoveTask $removeTask
     * @throws EntityNotFoundException
     * @throws OwnershipMismatchException
     */
    public function __invoke(RemoveTask $removeTask): void
    {
        $task = $this->taskRepository->findById(new TaskId($removeTask->getId()));
        $this->ownershipPolicy->verify($task);

        $task->remove();

        $this->taskRepository->save($task);
    }
}
