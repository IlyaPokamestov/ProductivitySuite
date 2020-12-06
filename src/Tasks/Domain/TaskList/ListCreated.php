<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Event;

/**
 * Class ListCreated
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList
 */
final class ListCreated implements Event
{
    /** @var string */
    private string $id;
    /** @var string */
    private string $name;

    /**
     * ListCreated constructor.
     * @param string $id
     * @param string $name
     */
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
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
    public function getName(): string
    {
        return $this->name;
    }
}
