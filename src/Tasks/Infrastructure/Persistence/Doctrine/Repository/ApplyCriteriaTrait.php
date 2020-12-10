<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Persistence\Doctrine\Repository;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\Criteria\CriteriaInterface;

/**
 * Trait FindByCriteriaTrait
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Persistence\Doctrine\Repository
 */
trait ApplyCriteriaTrait
{
    /** @var CriteriaToDoctrineCriteriaConverter */
    private CriteriaToDoctrineCriteriaConverter $converter;

    /**
     * @param CriteriaInterface $criteria
     * @return array
     */
    private function applyCriteria(CriteriaInterface $criteria): array
    {
        $doctrineCriteria = $this->converter->convert($criteria);

        $query = $this->repository->createQueryBuilder('o')
            ->addCriteria($doctrineCriteria)
            ->getQuery();

        return $query->getResult();
    }
}
