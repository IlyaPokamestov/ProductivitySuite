<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel\TaskListReadModel;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\TaskList as AggregateTaskList;
use Iterator;

/**
 * Interface ListReadRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel
 */
interface ListReadRepository
{
    /**
     * Find by id.
     *
     * @param string $id
     * @return TaskListReadModel
     * @throws EntityNotFoundException
     */
    public function findById(string $id): TaskListReadModel;

    /**
     * Find by criteria.
     *
     * @param mixed $criteria
     * @return Iterator
     */
    public function findBy($criteria): Iterator;

    /**
     * Find aggregate by ID.
     *
     * TODO: Still not a good one.
     *
     * @param string $id
     * @return AggregateTaskList
     */
    public function findAggregateById(string $id): AggregateTaskList;
}
