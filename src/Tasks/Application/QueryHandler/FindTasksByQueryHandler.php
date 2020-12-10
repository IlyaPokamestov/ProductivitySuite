<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\QueryHandler;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\QueryHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\FindTasksByCriteria;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel\TaskReadRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Policy\OwnershipPolicy;

/**
 * Class FindTasksByQueryHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\QueryHandler
 */
class FindTasksByQueryHandler implements QueryHandlerInterface
{
    /** @var TaskReadRepository */
    public TaskReadRepository $taskRepository;
    /** @var OwnershipPolicy */
    public OwnershipPolicy $ownershipPolicy;

    /**
     * FindTasksByHandler constructor.
     * @param TaskReadRepository $taskRepository
     * @param OwnershipPolicy $ownershipPolicy
     */
    public function __construct(TaskReadRepository $taskRepository, OwnershipPolicy $ownershipPolicy)
    {
        $this->taskRepository = $taskRepository;
        $this->ownershipPolicy = $ownershipPolicy;
    }

    /**
     * @param FindTasksByCriteria $findTasksBy
     * @return array
     */
    public function __invoke(FindTasksByCriteria $findTasksBy)
    {
        return $this->taskRepository->findByCriteria($findTasksBy->getCriteria());
    }
}
