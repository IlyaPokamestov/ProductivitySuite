<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\TaskList;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class CreateList
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command
 */
class CreateList
{
    /** @var string */
    private string $name;

    /**
     * @Serializer\SerializedName("ownerId")
     *
     * @var string
     */
    private string $ownerId;

    /**
     * CreateList constructor.
     * @param string $name
     * @param string $ownerId
     */
    public function __construct(string $name, string $ownerId)
    {
        $this->name = $name;
        $this->ownerId = $ownerId;
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
