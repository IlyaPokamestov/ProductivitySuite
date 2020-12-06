<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task;

use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

/**
 * Class TaskHandler
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList
 */
class TaskHandler implements MessageSubscriberInterface
{
    /** @var TaskRepository */
    public TaskRepository $taskRepository;

    /**
     * TaskHandler constructor.
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param FindById $findById
     * @return Task
     */
    public function findById(FindById $findById): Task
    {
        return $this->taskRepository->findById($findById->getId());
    }

    /** {@inheritDoc} */
    public static function getHandledMessages(): iterable
    {
        yield FindById::class => [
            'method' => 'findById',
        ];
    }
}
