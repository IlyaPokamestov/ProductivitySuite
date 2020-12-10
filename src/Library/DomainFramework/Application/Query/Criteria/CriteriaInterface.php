<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\Criteria;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\PaginationInterface;

/**
 * Interface CriteriaInterface
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query
 */
interface CriteriaInterface
{
    /**
     * Returns pagination.
     *
     * @return ?PaginationInterface
     */
    public function getPagination(): ?PaginationInterface;

    /**
     * Apply where expressions.
     *
     * @param array $expressions
     */
    public function where(array $expressions): void;

    /**
     * Returns applied where expressions.
     *
     * @return array
     */
    public function getWhere(): array;
}
