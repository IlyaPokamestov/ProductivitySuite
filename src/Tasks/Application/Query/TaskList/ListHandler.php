<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\QueryHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Policy\OwnershipPolicy;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListRepository as DomainListRepository;

/**
 * Class ListHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList
 */
class ListHandler implements QueryHandlerInterface
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
        //TODO: Find a better way how to verify ownership on view model.
        if ($this->listRepository instanceof DomainListRepository) {
            $listAggregate = $this->listRepository->findListById(new ListId($findById->getId()));

            $this->ownershipPolicy->verify($listAggregate);
        }


        return $this->listRepository->findById($findById->getId());
    }
}
