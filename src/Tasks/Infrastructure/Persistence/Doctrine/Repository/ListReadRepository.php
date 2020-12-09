<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Persistence\Doctrine\Repository;

use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel\ListReadRepository as ReadRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel\TaskListReadModel;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\TaskList;

/**
 * Class ListReadRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Persistence\Doctrine\Repository
 */
class ListReadRepository implements ReadRepository
{
    use FindByCriteriaTrait;

    /** @var ListRepository */
    private ListRepository $repository;

    /**
     * ListRepository constructor.
     * @param ListRepository $repository
     */
    public function __construct(ListRepository $repository)
    {
        $this->repository = $repository;
    }

    /** {@inheritDoc} */
    public function findById(string $id): TaskListReadModel
    {
        return $this->map($this->findAggregateById($id));
    }

    /** {@inheritDoc} */
    public function findAggregateById(string $id): TaskList
    {
        return $this->repository->findById(new ListId($id));
    }

    /** {@inheritDoc} */
    protected function map(TaskList $object)
    {
        return new TaskListReadModel(
            (string) $object->getId(),
            $object->getName()
        );
    }
}
