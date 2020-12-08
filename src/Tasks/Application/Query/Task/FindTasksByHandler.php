<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\QueryHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Policy\OwnershipPolicy;

/**
 * Class FindTasksByHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task
 */
class FindTasksByHandler implements QueryHandlerInterface
{
    /** @var TaskRepository */
    public TaskRepository $taskRepository;
    /** @var OwnershipPolicy */
    public OwnershipPolicy $ownershipPolicy;

    /**
     * FindTasksByHandler constructor.
     * @param TaskRepository $taskRepository
     * @param OwnershipPolicy $ownershipPolicy
     */
    public function __construct(TaskRepository $taskRepository, OwnershipPolicy $ownershipPolicy)
    {
        $this->taskRepository = $taskRepository;
        $this->ownershipPolicy = $ownershipPolicy;
    }

    /**
     * @param FindTasksBy $findTasksBy
     * @return \Iterator
     */
    public function __invoke(FindTasksBy $findTasksBy)
    {
        return $this->taskRepository->findBy($findTasksBy->getCriteria());
    }
}
