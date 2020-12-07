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
    /** @var string */
    private string $ownerId;

    /**
     * ListCreated constructor.
     * @param string $id
     * @param string $name
     * @param string $ownerId
     */
    public function __construct(string $id, string $name, string $ownerId)
    {
        $this->id = $id;
        $this->name = $name;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getOwnerId(): string
    {
        return $this->ownerId;
    }
}
