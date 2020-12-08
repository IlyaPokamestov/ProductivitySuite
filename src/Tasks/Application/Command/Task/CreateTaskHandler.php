<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\CommandHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\OwnerId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Policy\OwnerRegisteredPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Description;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListRepository;

/**
 * Class CreateTaskHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task
 */
class CreateTaskHandler implements CommandHandlerInterface
{
    /** @var TaskRepository */
    private TaskRepository $taskRepository;
    /** @var OwnerRegisteredPolicy */
    private OwnerRegisteredPolicy $ownerRegisteredPolicy;
    /** @var ListRepository */
    private ListRepository $listRepository;

    /**
     * CreateTaskHandler constructor.
     * @param TaskRepository $taskRepository
     * @param OwnerRegisteredPolicy $ownerRegisteredPolicy
     * @param ListRepository $listRepository
     */
    public function __construct(
        TaskRepository $taskRepository,
        OwnerRegisteredPolicy $ownerRegisteredPolicy,
        ListRepository $listRepository
    ) {
        $this->taskRepository = $taskRepository;
        $this->ownerRegisteredPolicy = $ownerRegisteredPolicy;
        $this->listRepository = $listRepository;
    }

    /**
     * @param CreateTask $createTask
     * @return string
     */
    public function __invoke(CreateTask $createTask): string
    {
        $ownerId = new OwnerId($createTask->getOwnerId());
        $this->ownerRegisteredPolicy->verify($ownerId);

        $listId = new ListId($createTask->getListId());
        $this->listRepository->findById($listId);

        $task = Task::create(
            TaskId::generate(),
            $listId,
            new Description($createTask->getTitle(), $createTask->getNote()),
            $ownerId
        );

        $this->taskRepository->save($task);

        return (string) $task->getId();
    }
}
