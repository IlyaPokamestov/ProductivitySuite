<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Event;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Event;

/**
 * Class TaskCompleted
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Event
 */
final class TaskCompleted implements Event
{
    /** @var string */
    private string $id;

    /**
     * TaskCompleted constructor.
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
