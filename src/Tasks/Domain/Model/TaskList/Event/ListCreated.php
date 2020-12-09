<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\Event;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\EventInterface;

/**
 * Class ListCreated
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\Event
 */
final class ListCreated implements EventInterface
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
