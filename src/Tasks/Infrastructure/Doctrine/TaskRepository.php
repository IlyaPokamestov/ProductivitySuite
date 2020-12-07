<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskRepository as WriteRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task\TaskRepository as ReadRepository;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task\Task as ReadOnlyTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Task;

/**
 * Class ListRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine
 */
class TaskRepository extends ServiceEntityRepository implements WriteRepository, ReadRepository
{
    /** {@inheritDoc} */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /** @var array */
    private array $tasks = [];

    /** {@inheritDoc} */
    public function save(Task $task): void
    {
        $this->getEntityManager()->persist($task);
        if ($task->isRemoved()) {
            $this->getEntityManager()->remove($task);
        }

        $this->getEntityManager()->flush();
    }

    /** {@inheritDoc} */
    public function findById(TaskId $id): Task
    {
        /** @var Task $task */
        $task = $this->find((string) $id);
        if (null === $task) {
            throw new EntityNotFoundException('Task not found!');
        }

        return $task;
    }

    /** {@inheritDoc} */
    public function findTaskById(string $id): ReadOnlyTask
    {
        $task = $this->findById(new TaskId($id));

        return new ReadOnlyTask(
            (string) $task->getId(),
            $task->getDescription()->getTitle(),
            (string) $task->getListId(),
        );
    }
}
