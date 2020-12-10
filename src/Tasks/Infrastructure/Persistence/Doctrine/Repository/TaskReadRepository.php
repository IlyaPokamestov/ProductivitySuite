<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Persistence\Doctrine\Repository;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\Criteria\CriteriaInterface;
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
    use ApplyCriteriaTrait;

    /** @var TaskRepository */
    private TaskRepository $repository;

    /**
     * TaskReadRepository constructor.
     * @param TaskRepository $repository
     * @param CriteriaToDoctrineCriteriaConverter $converter
     */
    public function __construct(TaskRepository $repository, CriteriaToDoctrineCriteriaConverter $converter)
    {
        $this->repository = $repository;
        $this->converter = $converter;
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
    public function findByCriteria(CriteriaInterface $criteria): array
    {
        $results = $this->applyCriteria($criteria);

        return array_map([$this, 'map'], $results);
    }

    /**
     * @param Task $task
     * @return TaskReadModel
     */
    private function map(Task $task)
    {
        return new TaskReadModel(
            (string) $task->getId(),
            $task->getDescription()->getTitle(),
            (string) $task->getListId(),
        );
    }
}
