<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList;

use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\QueryHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Policy\OwnershipPolicy;

/**
 * Class FindByHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList
 */
class FindByHandler implements QueryHandlerInterface
{
    /** @var ListRepository */
    public ListRepository $listRepository;
    /** @var OwnershipPolicy */
    public OwnershipPolicy $ownershipPolicy;

    /**
     * FindByHandler constructor.
     * @param ListRepository $listRepository
     * @param OwnershipPolicy $ownershipPolicy
     */
    public function __construct(ListRepository $listRepository, OwnershipPolicy $ownershipPolicy)
    {
        $this->listRepository = $listRepository;
        $this->ownershipPolicy = $ownershipPolicy;
    }

    /**
     * @param FindBy $findBy
     * @return \Iterator
     */
    public function __invoke(FindBy $findBy)
    {
        return $this->listRepository->findBy($findBy->getCriteria());
    }
}
