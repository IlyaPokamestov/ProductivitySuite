<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Event;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\EventInterface;

/**
 * Class TaskMoved
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Event
 */
final class TaskMoved implements EventInterface
{
    /** @var string */
    private string $id;
    /** @var string */
    private string $listId;

    /**
     * TaskCreated constructor.
     * @param string $id
     * @param string $listId
     */
    public function __construct(string $id, string $listId)
    {
        $this->id = $id;
        $this->listId = $listId;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getListId(): string
    {
        return $this->listId;
    }
}
