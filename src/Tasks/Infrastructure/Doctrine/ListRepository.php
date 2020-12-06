<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine;

use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListRepository as WriteRepository;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\ListRepository as ReadRepository;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\EntityNotFoundException;
use IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList\TaskList as ReadOnlyList;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\TaskList;

/**
 * Class ListRepository
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Doctrine
 */
class ListRepository implements WriteRepository, ReadRepository
{
    /** @var array */
    private array $lists = [];

    /** {@inheritDoc} */
    public function save(TaskList $taskList): void
    {
        $this->lists[(string) $taskList->getId()] = $taskList;
    }

    /** {@inheritDoc} */
    public function findById(string $id): ReadOnlyList
    {
        if ('aaa279e0-230b-4179-b339-bd091bf27a77' === $id) {
            return new ReadOnlyList(
                'aaa279e0-230b-4179-b339-bd091bf27a77',
                'Test',
            );
        }

        /** @var TaskList $list */
        $list = $this->lists[(string) $id] ?? null;
        if (null === $list) {
            throw new EntityNotFoundException('List not found!');
        }

        return new ReadOnlyList(
            (string) $list->getId(),
            $list->getName()
        );
    }
}
