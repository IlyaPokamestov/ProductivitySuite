<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Events;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Event;

/**
 * Class TaskCreated
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList
 */
final class TaskCreated implements Event
{
    /** @var string */
    private string $id;
    /** @var string */
    private string $listId;
    /** @var string */
    private string $title;
    /** @var string */
    private string $note;

    /**
     * TaskCreated constructor.
     * @param string $id
     * @param string $listId
     * @param string $title
     * @param string $note
     */
    public function __construct(string $id, string $listId, string $title, string $note)
    {
        $this->id = $id;
        $this->listId = $listId;
        $this->title = $title;
        $this->note = $note;
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

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getNote(): string
    {
        return $this->note;
    }
}
