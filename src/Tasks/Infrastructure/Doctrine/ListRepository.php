<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListRepository as WriteRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\ListRepository as ReadRepository;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\TaskList as ReadOnlyList;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\TaskList;

/**
 * Class ListRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine
 */
class ListRepository extends ServiceEntityRepository implements WriteRepository, ReadRepository
{
    /** {@inheritDoc} */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskList::class);
    }

    /** @var array */
    private array $lists = [];

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
    public function findById(string $id): ReadOnlyList
    {
        $list = $this->find($id);
        if (null === $list) {
            throw new EntityNotFoundException('List not found!');
        }

        return new ReadOnlyList(
            (string) $list->getId(),
            $list->getName()
        );
    }
}
