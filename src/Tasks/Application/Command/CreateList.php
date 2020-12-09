<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\CommandInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\ListId;

/**
 * Class CreateList
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command
 */
final class CreateList implements CommandInterface
{
    /** @var ListId */
    private ListId $id;
    /** @var string */
    private string $name;
    /** @var string */
    private string $ownerId;

    /**
     * CreateList constructor.
     * @param string $name
     * @param string $ownerId
     */
    public function __construct(string $name, string $ownerId)
    {
        $this->id = ListId::generate();
        $this->name = $name;
        $this->ownerId = $ownerId;
    }

    /**
     * @return ListId
     */
    public function getId(): ListId
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
