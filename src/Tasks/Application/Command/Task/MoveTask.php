<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task;

/**
 * Class MoveTask
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task
 */
class MoveTask
{
    /** @var string */
    private string $id;
    /** @var string */
    private string $listId;

    /**
     * MoveTask constructor.
     * @param string $id
     * @param string $listId
     */
    public function __construct(string $id, string $listId)
    {
        $this->id = $id;
        $this->listId = $listId;
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
    public function getListId(): string
    {
        return $this->listId;
    }
}
