<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList;

use IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\Criteria;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\TaskList as AggregateTaskList;
use Iterator;

/**
 * Interface ListRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList
 */
interface ListRepository
{
    /**
     * Find by id.
     *
     * @param string $id
     * @return TaskList
     * @throws EntityNotFoundException
     */
    public function findById(string $id): TaskList;

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
