<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\Criteria\CriteriaInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Task as AggregateTask;

/**
 * Interface TaskRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task
 */
interface TaskReadRepository
{
    /**
     * Find by id.
     *
     * @param string $id
     * @return TaskReadModel
     * @throws EntityNotFoundException
     */
    public function findById(string $id): TaskReadModel;

    /**
     * Find by criteria.
     *
     * @param CriteriaInterface $criteria
     * @return array
     */
    public function findByCriteria(CriteriaInterface $criteria): array;

    /**
     * Find aggregate by ID.
     *
     * TODO: Still not a good one.
     *
     * @param string $id
     * @return AggregateTask
     */
    public function findAggregateById(string $id): AggregateTask;
}
