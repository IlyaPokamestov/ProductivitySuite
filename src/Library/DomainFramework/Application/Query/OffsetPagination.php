<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Assert;

/**
 * Class OffsetPagination
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query
 */
final class OffsetPagination implements PaginationInterface
{
    /** @var int */
    private int $offset;
    /** @var int */
    private int $limit;
    /** @var int */
    private int $defaultLimit;
    /** @var int */
    private int $maxLimit;

    /**
     * OffsetPagination constructor.
     * @param int $offset
     * @param int $limit
     * @param int $defaultLimit
     * @param int $maxLimit
     */
    public function __construct(
        int $offset,
        int $limit,
        int $defaultLimit = self::LIMIT_DEFAULT,
        int $maxLimit = self::LIMIT_MAX
    ) {
        Assert::greaterThanEq($limit, 0, 'Limit should be greater than zero!');
        Assert::greaterThanEq($offset, 0, 'Offset should be greater than zero!');
        Assert::lessThanEq($limit, $maxLimit, sprintf('Limit should be less than %d!', $maxLimit));

        $this->offset = $offset;
        $this->limit = $limit;
        $this->defaultLimit = $defaultLimit;
        $this->maxLimit = $maxLimit;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }
}
