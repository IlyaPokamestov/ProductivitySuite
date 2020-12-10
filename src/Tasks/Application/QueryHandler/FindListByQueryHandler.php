<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\QueryHandler;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\QueryHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\FindListByCriteria;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel\ListReadRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Policy\OwnershipPolicy;

/**
 * Class FindListByQueryHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\QueryHandler
 */
class FindListByQueryHandler implements QueryHandlerInterface
{
    /** @var ListReadRepository */
    public ListReadRepository $listRepository;
    /** @var OwnershipPolicy */
    public OwnershipPolicy $ownershipPolicy;

    /**
     * FindByHandler constructor.
     * @param ListReadRepository $listRepository
     * @param OwnershipPolicy $ownershipPolicy
     */
    public function __construct(ListReadRepository $listRepository, OwnershipPolicy $ownershipPolicy)
    {
        $this->listRepository = $listRepository;
        $this->ownershipPolicy = $ownershipPolicy;
    }

    /**
     * @param FindListByCriteria $findBy
     * @return array
     */
    public function __invoke(FindListByCriteria $findBy)
    {
        return $this->listRepository->findByCriteria($findBy->getCriteria());
    }
}
