<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task;

/**
 * Class UpdateTask
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task
 */
class UpdateTask
{
    /** @var string */
    private string $id;
    /** @var string */
    private string $title;
    /** @var string */
    private string $note = '';

    /**
     * UpdateTask constructor.
     * @param string $id
     * @param string $title
     * @param string $note
     */
    public function __construct(string $id, string $title, string $note)
    {
        $this->id = $id;
        $this->title = $title;
        $this->note = $note;
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
}
