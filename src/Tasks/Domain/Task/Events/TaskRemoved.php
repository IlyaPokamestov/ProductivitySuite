<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Events;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Event;

/**
 * Class TaskRemoved
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList
 */
final class TaskRemoved implements Event
{
    /** @var string */
    private string $id;

    /**
     * TaskRemoved constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
