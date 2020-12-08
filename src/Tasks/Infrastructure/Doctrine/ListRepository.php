<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListRepository as WriteRepository;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\TaskList;

/**
 * Class ListRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine
 */
class ListRepository extends ServiceEntityRepository implements WriteRepository
{
    /** {@inheritDoc} */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskList::class);
    }

    /** {@inheritDoc} */
    public function save(TaskList $list): void
    {
        $this->getEntityManager()->persist($list);
        if ($list->isRemoved()) {
            $this->getEntityManager()->remove($list);
        }

        $this->getEntityManager()->flush();
    }

    /** {@inheritDoc} */
    public function findById(ListId $id): TaskList
    {
        /** @var TaskList|null $list */
        $list = $this->find((string) $id);
        if (null === $list) {
            throw new EntityNotFoundException('List not found!');
        }

        return $list;
    }
}
