<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Event;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\EventInterface;

/**
 * Class TaskCreated
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Event
 */
final class TaskCreated implements EventInterface
{
    /** @var string */
    private string $id;
    /** @var string */
    private string $listId;
    /** @var string */
    private string $title;
    /** @var string */
    private string $note = '';
    /** @var string */
    private string $ownerId;

    /**
     * TaskCreated constructor.
     * @param string $id
     * @param string $listId
     * @param string $title
     * @param string $note
     * @param string $ownerId
     */
    public function __construct(string $id, string $listId, string $title, string $note, string $ownerId)
    {
        $this->id = $id;
        $this->listId = $listId;
        $this->title = $title;
        $this->note = $note;
        $this->ownerId = $ownerId;
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

    /**
     * @return string
     */
    public function getOwnerId(): string
    {
        return $this->ownerId;
    }
}
