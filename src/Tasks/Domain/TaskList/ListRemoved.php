<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Event;

/**
 * Class ListRemoved
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList
 */
final class ListRemoved implements Event
{
    /** @var string */
    private string $id;

    /**
     * ListRemoved constructor.
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
