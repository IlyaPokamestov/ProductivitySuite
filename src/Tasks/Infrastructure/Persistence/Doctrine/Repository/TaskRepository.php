<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Repository\TaskRepository as WriteRepository;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\ListId;

/**
 * Class TaskRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Persistence\Doctrine\Repository
 */
class TaskRepository extends ServiceEntityRepository implements WriteRepository
{
    /** {@inheritDoc} */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

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
        /** @var Task|null $task */
        $task = $this->find((string) $id);
        if (null === $task) {
            throw new EntityNotFoundException('Task not found!');
        }

        return $task;
    }

    /** {@inheritDoc} */
    public function removeByListId(ListId $id): void
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->delete(Task::class, 't')
            ->where('t.listId = :listId')
            ->setParameter('listId', (string) $id);

        $qb->getQuery()->execute();

        $this->getEntityManager()->flush();
    }
}
