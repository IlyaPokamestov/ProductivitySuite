<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Persistence\Doctrine\Repository;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\Criteria\CriteriaInterface;
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
    use ApplyCriteriaTrait;

    /** @var ListRepository */
    private ListRepository $repository;

    /**
     * ListReadRepository constructor.
     * @param ListRepository $repository
     * @param CriteriaToDoctrineCriteriaConverter $converter
     */
    public function __construct(ListRepository $repository, CriteriaToDoctrineCriteriaConverter $converter)
    {
        $this->repository = $repository;
        $this->converter = $converter;
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
    public function findByCriteria(CriteriaInterface $criteria): array
    {
        $results = $this->applyCriteria($criteria);

        return array_map([$this, 'map'], $results);
    }

    /**
     * @param TaskList $object
     * @return TaskListReadModel
     */
    private function map(TaskList $object)
    {
        return new TaskListReadModel(
            (string) $object->getId(),
            $object->getName()
        );
    }
}
