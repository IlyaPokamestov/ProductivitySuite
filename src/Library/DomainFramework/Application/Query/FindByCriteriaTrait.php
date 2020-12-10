<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\Criteria\CriteriaInterface;

/**
 * Class FindByCriteriaTrait
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query
 */
trait FindByCriteriaTrait
{
    /** @var CriteriaInterface */
    private CriteriaInterface $criteria;

    /**
     * FindByCriteriaTrait constructor.
     * @param CriteriaInterface $criteria
     */
    public function __construct(CriteriaInterface $criteria)
    {
        $this->criteria = $criteria;
    }

    /**
     * @return CriteriaInterface
     */
    public function getCriteria(): CriteriaInterface
    {
        return $this->criteria;
    }
}
