<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query;

use IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\Criteria;
use Doctrine\Common\Collections\Criteria as BaseCriteria;

/**
 * Class FindByCriteria
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query
 */
class FindByCriteria
{
    /** @var Criteria|BaseCriteria */
    private $criteria;

    /**
     * FindBy constructor.
     * @param Criteria|BaseCriteria $criteria
     */
    public function __construct($criteria)
    {
        $this->criteria = $criteria;
    }

    /**
     * @return Criteria|BaseCriteria
     */
    public function getCriteria()
    {
        return $this->criteria;
    }
}
