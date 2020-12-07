<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class CreateTask
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\Task
 */
class CreateTask
{
    /** @var string */
    private string $title;
    /** @var string */
    private string $note;
    /**
     * @var string
     * @Serializer\SerializedName("listId")
     */
    private string $listId;
    /**
     * @var string
     * @Serializer\SerializedName("ownerId")
     */
    private string $ownerId;

    /**
     * CreateTask constructor.
     * @param string $title
     * @param string $note
     * @param string $listId
     * @param string $ownerId
     */
    public function __construct(string $title, string $note, string $listId, string $ownerId)
    {
        $this->title = $title;
        $this->note = $note;
        $this->listId = $listId;
        $this->ownerId = $ownerId;
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

    /**
     * @return string
     */
    public function getOwnerId(): string
    {
        return $this->ownerId;
    }
}
