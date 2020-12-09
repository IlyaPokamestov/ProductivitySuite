<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\QueryHandler;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\QueryHandlerInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\FindTaskById;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel\TaskReadModel;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel\TaskReadRepository;

/**
 * Class FindTaskByIdQueryHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\QueryHandler
 */
class FindTaskByIdQueryHandler implements QueryHandlerInterface
{
    /** @var TaskReadRepository */
    public TaskReadRepository $taskRepository;

    /**
     * TaskHandler constructor.
     * @param TaskReadRepository $taskRepository
     */
    public function __construct(TaskReadRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param FindTaskById $findById
     * @return TaskReadModel
     */
    public function __invoke(FindTaskById $findById)
    {
        return $this->taskRepository->findById($findById->getId());
    }
}
