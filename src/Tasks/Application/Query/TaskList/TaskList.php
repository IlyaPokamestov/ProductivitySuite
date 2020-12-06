<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class TaskList
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList
 */
class TaskList
{
    /** @var string */
    private string $id;
    /**
     * @var string
     * @Serializer\SerializedName("name")
     */
    private string $name;

    /**
     * TaskList constructor.
     * @param string $id
     * @param string $name
     */
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}
