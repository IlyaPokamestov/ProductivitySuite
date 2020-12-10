<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\Criteria;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\PaginationInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Assert;

/**
 * Class Criteria
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\Criteria
 */
class Criteria implements CriteriaInterface
{
    /** @var ?PaginationInterface */
    private ?PaginationInterface $pagination;
    /** @var array */
    private array $whereExpressions = [];

    /**
     * Criteria constructor.
     * @param PaginationInterface|null $pagination
     */
    public function __construct(PaginationInterface $pagination = null)
    {
        $this->pagination = $pagination;
    }

    /** {@inheritDoc} */
    public function getPagination(): ?PaginationInterface
    {
        return $this->pagination;
    }

    /** {@inheritDoc} */
    public function where(array $expressions): void
    {
        Assert::allIsInstanceOf($expressions, ExpressionInterface::class);

        $this->whereExpressions = $expressions;
    }

    /** {@inheritDoc} */
    public function getWhere(): array
    {
        return $this->whereExpressions;
    }
}
