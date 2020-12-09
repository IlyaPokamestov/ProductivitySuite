<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Persistence\Doctrine\Repository;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel\TaskReadModel;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel\TaskReadRepository as ReadRepository;

/**
 * Class TaskReadRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Persistence\Doctrine\Repository
 */
class TaskReadRepository implements ReadRepository
{
    use FindByCriteriaTrait;

    /** @var TaskRepository */
    private TaskRepository $repository;

    /**
     * TaskRepository constructor.
     * @param TaskRepository $repository
     */
    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    /** {@inheritDoc} */
    public function findById(string $id): TaskReadModel
    {
        return $this->map($this->findAggregateById($id));
    }

    /** {@inheritDoc} */
    public function findAggregateById(string $id): Task
    {
        return $this->repository->findById(new TaskId($id));
    }

    /** {@inheritDoc} */
    protected function map(Task $task)
    {
        return new TaskReadModel(
            (string) $task->getId(),
            $task->getDescription()->getTitle(),
            (string) $task->getListId(),
        );
    }
}
