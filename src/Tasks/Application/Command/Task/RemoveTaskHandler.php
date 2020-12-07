<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\CommandHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\OwnershipMismatchException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Policy\OwnershipPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskRepository;

/**
 * Class RemoveTaskHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task
 */
class RemoveTaskHandler implements CommandHandlerInterface
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
    public function __invoke(RemoveTask $removeTask)
    {
        $task = $this->taskRepository->findById(new TaskId($removeTask->getId()));
        $this->ownershipPolicy->verify($task);

        $task->remove();

        $this->taskRepository->save($task);
    }
}
