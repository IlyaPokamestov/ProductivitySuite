<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\Common\Collections\Criteria;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\Criteria\CriteriaInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\Criteria\Expression\Equal;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\OffsetPagination;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\InvalidArgumentException;

/**
 * Class CriteriaToDoctrineCriteriaConverter
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Persistence\Doctrine\Repository
 */
class CriteriaToDoctrineCriteriaConverter
{
    /**
     * @param CriteriaInterface $criteria
     * @return Criteria
     */
    public function convert(CriteriaInterface $criteria): Criteria
    {
        $doctrineCriteria = $this->convertPagination(Criteria::create(), $criteria);

        return $this->convertWhere($doctrineCriteria, $criteria);
    }

    /**
     * @param Criteria $doctrineCriteria
     * @param CriteriaInterface $criteria
     * @return Criteria
     */
    private function convertPagination(Criteria $doctrineCriteria, CriteriaInterface $criteria): Criteria
    {
        $pagination = $criteria->getPagination();
        if (null === $pagination) {
            return $doctrineCriteria;
        }

        if ($pagination instanceof OffsetPagination) {
            return $doctrineCriteria->setMaxResults($pagination->getLimit())
                ->setFirstResult($pagination->getOffset());
        } else {
            throw new InvalidArgumentException(
                'Pagination type is not supported, only offset pagination is allowed!'
            );
        }
    }

    /**
     * TODO: Better to use Chain Responsibility instead. Keeping methods to simplify things.
     *
     * @param Criteria $doctrineCriteria
     * @param CriteriaInterface $criteria
     * @return Criteria
     */
    private function convertWhere(Criteria $doctrineCriteria, CriteriaInterface $criteria): Criteria
    {
        $first = true;
        foreach ($criteria->getWhere() as $expression) {
            //TODO: The same here.
            switch (true) {
                case $expression instanceof Equal:
                    $doctrineExpression = Criteria::expr()->eq($expression->getField(), $expression->getValue());

                    if ($first) {
                        $doctrineCriteria = $doctrineCriteria->where($doctrineExpression);
                        $first = false;
                    } else {
                        $doctrineCriteria = $doctrineCriteria->andWhere($doctrineExpression);
                    }

                    break;
                default:
                    throw new InvalidArgumentException('Expression type is unknown!');
            }
        }

        return $doctrineCriteria;
    }
}
