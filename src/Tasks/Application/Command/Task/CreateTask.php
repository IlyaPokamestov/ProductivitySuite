<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task;

/**
 * Class CreateTask
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task
 */
class CreateTask
{
    /** @var string */
    private string $title;
    /** @var string */
    private string $note = '';
    /** @var string */
    private string $listId;

    /**
     * CreateTask constructor.
     * @param string $title
     * @param string $note
     * @param string $listId
     */
    public function __construct(string $title, string $note, string $listId)
    {
        $this->title = $title;
        $this->note = $note;
        $this->listId = $listId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getNote(): string
    {
        return $this->note;
    }

    /**
     * @return string
     */
    public function getListId(): string
    {
        return $this->listId;
    }
}
