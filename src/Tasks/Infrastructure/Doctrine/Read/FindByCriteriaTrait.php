<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine\Read;

use IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework\Criteria;
use Doctrine\Common\Collections\Criteria as BaseCriteria;
use Iterator;

/**
 * Trait FindByCriteriaTrait
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine\Read
 */
trait FindByCriteriaTrait
{
    /**
     * @param Criteria|BaseCriteria $criteria
     * @return Iterator
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function findBy($criteria): \Iterator
    {
        $query = $this->repository->createQueryBuilder('o')
            ->addCriteria($criteria)
            ->getQuery();

        foreach ($query->getResult() as $task) {
            yield $this->map($task);
        }
    }

    /**
     * Map object to read model.
     *
     * @param mixed $object
     * @return mixed
     */
    abstract protected function map($object);
}
