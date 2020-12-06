<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine;

use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Description;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\TaskRepository as WriteRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task\TaskRepository as ReadRepository;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\Task\Task as ReadOnlyTask;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Task;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;

/**
 * Class ListRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine
 */
class TaskRepository implements WriteRepository, ReadRepository
{
    /** @var array */
    private array $tasks = [];

    /** {@inheritDoc} */
    public function save(Task $task): void
    {
        $this->tasks[(string) $task->getId()] = $task;
    }

    /** {@inheritDoc} */
    public function find(TaskId $id): Task
    {
        return Task::create(
            TaskId::generate(),
            ListId::generate(),
            new Description('Test')
        );
    }

    /** {@inheritDoc} */
    public function findById(string $id): ReadOnlyTask
    {
        if ('aaa279e0-230b-4179-b339-bd091bf27a77' === $id) {
            return new ReadOnlyTask(
                'aaa279e0-230b-4179-b339-bd091bf27a77',
                'Test',
            );
        }

        /** @var Task $task */
        $task = $this->tasks[(string) $id] ?? null;
        if (null === $task) {
            throw new EntityNotFoundException('Task not found!');
        }

        return new ReadOnlyTask(
            (string) $task->getId(),
            $task->getDescription()->getTitle(),
            (string) $task->getListId(),
        );
    }
}
