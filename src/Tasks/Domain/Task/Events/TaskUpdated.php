<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Events;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Event;

/**
 * Class TaskUpdated
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Events
 */
final class TaskUpdated implements Event
{
    /** @var string */
    private string $id;
    /** @var string */
    private string $title;
    /** @var string */
    private string $note;

    /**
     * TaskUpdated constructor.
     * @param string $id
     * @param string $title
     * @param string $note
     */
    public function __construct(string $id, string $title, string $note)
    {
        $this->id = $id;
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
