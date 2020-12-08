<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\QueryHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Policy\OwnershipPolicy;

/**
 * Class FindByIdHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList
 */
class FindByIdHandler implements QueryHandlerInterface
{
    /** @var ListRepository */
    public ListRepository $listRepository;
    /** @var OwnershipPolicy */
    public OwnershipPolicy $ownershipPolicy;

    /**
     * ListHandler constructor.
     * @param ListRepository $listRepository
     * @param OwnershipPolicy $ownershipPolicy
     */
    public function __construct(ListRepository $listRepository, OwnershipPolicy $ownershipPolicy)
    {
        $this->listRepository = $listRepository;
        $this->ownershipPolicy = $ownershipPolicy;
    }

    /**
     * @param FindById $findById
     * @return TaskList
     */
    public function __invoke(FindById $findById): TaskList
    {
        $listAggregate = $this->listRepository->findAggregateById($findById->getId());
        $this->ownershipPolicy->verify($listAggregate);

        return $this->listRepository->findById($findById->getId());
    }
}
