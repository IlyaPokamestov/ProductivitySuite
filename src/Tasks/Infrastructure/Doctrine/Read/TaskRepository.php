<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine\Read;

use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Task as AggregateTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task\TaskRepository as ReadRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine\TaskRepository as WriteRepository;

/**
 * Class ListRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine
 */
class TaskRepository implements ReadRepository
{
    use FindByCriteriaTrait;

    /** @var WriteRepository */
    private WriteRepository $repository;

    /**
     * TaskRepository constructor.
     * @param WriteRepository $repository
     */
    public function __construct(WriteRepository $repository)
    {
        $this->repository = $repository;
    }

    /** {@inheritDoc} */
    public function findById(string $id): Task
    {
        return $this->map($this->findAggregateById($id));
    }

    /** {@inheritDoc} */
    public function findAggregateById(string $id): AggregateTask
    {
        return $this->repository->findById(new TaskId($id));
    }

    /** {@inheritDoc} */
    protected function map(AggregateTask $task)
    {
        return new Task(
            (string) $task->getId(),
            $task->getDescription()->getTitle(),
            (string) $task->getListId(),
        );
    }
}
