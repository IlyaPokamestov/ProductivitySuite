<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\QueryHandler;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\QueryHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\FindListById;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel\ListReadRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel\TaskListReadModel;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Policy\OwnershipPolicy;

/**
 * Class FindByListByIdQueryHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\QueryHandler
 */
class FindByListByIdQueryHandler implements QueryHandlerInterface
{
    /** @var ListReadRepository */
    public ListReadRepository $listRepository;
    /** @var OwnershipPolicy */
    public OwnershipPolicy $ownershipPolicy;

    /**
     * ListHandler constructor.
     * @param ListReadRepository $listRepository
     * @param OwnershipPolicy $ownershipPolicy
     */
    public function __construct(ListReadRepository $listRepository, OwnershipPolicy $ownershipPolicy)
    {
        $this->listRepository = $listRepository;
        $this->ownershipPolicy = $ownershipPolicy;
    }

    /**
     * @param FindListById $findById
     * @return TaskListReadModel
     */
    public function __invoke(FindListById $findById): TaskListReadModel
    {
        $listAggregate = $this->listRepository->findAggregateById($findById->getId());
        $this->ownershipPolicy->verify($listAggregate);

        return $this->listRepository->findById($findById->getId());
    }
}
