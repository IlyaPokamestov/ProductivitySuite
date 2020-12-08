<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine\Read;

use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\ListRepository as ReadRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\TaskList;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\TaskList as AggregateTaskList;
use IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine\ListRepository as WriteRepository;

/**
 * Class ListRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine\Read
 */
class ListRepository implements ReadRepository
{
    use FindByCriteriaTrait;

    /** @var WriteRepository */
    private WriteRepository $repository;

    /**
     * ListRepository constructor.
     * @param WriteRepository $repository
     */
    public function __construct(WriteRepository $repository)
    {
        $this->repository = $repository;
    }

    /** {@inheritDoc} */
    public function findById(string $id): TaskList
    {
        return $this->map($this->findAggregateById($id));
    }

    /** {@inheritDoc} */
    public function findAggregateById(string $id): AggregateTaskList
    {
        return $this->repository->findById(new ListId($id));
    }

    /** {@inheritDoc} */
    protected function map(AggregateTaskList $object)
    {
        return new TaskList(
            (string) $object->getId(),
            $object->getName()
        );
    }
}
