<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Events;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Event;

/**
 * Class TaskMoved
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Events
 */
final class TaskMoved implements Event
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
