<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task;

/**
 * Class RemoveAllTasksWhichBelongsToList
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task
 */
class RemoveAllTasksWhichBelongsToList
{
    /** @var string */
    private string $id;

    /**
     * RemoveTask constructor.
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
