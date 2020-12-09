<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\CommandHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\CreateTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Owner\OwnerId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Policy\OwnerRegisteredPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Description;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository\TaskRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository\ListRepository;

/**
 * Class CreateTaskCommandHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\CommandHandler
 */
class CreateTaskCommandHandler implements CommandHandlerInterface
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
     */
    public function __invoke(CreateTask $createTask)
    {
        $ownerId = new OwnerId($createTask->getOwnerId());
        $this->ownerRegisteredPolicy->verify($ownerId);

        $listId = new ListId($createTask->getListId());
        $this->listRepository->findById($listId);

        $task = Task::create(
            $createTask->getId(),
            $listId,
            new Description($createTask->getTitle(), $createTask->getNote()),
            $ownerId
        );

        $this->taskRepository->save($task);
    }
}
