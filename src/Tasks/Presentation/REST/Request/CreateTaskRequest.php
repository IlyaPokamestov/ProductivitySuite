<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Request;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CreateTaskRequest
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Request
 */
final class CreateTaskRequest
{
    /**
     * @Assert\NotNull(message="Title can not be empty.")
     * @Assert\Length(
     *     min="1",
     *     max="150",
     *     minMessage="Title should be more than 1 character lenght",
     *     maxMessage="Title can not be more than 150 characters lenght"
     * )
     *
     * @var string
     */
    private string $title;

    /**
     *
     * @Assert\NotNull(message="Note can not be empty.")
     * @Assert\Length(
     *     max="1000",
     *     maxMessage="Note can not be more than 1000 characters lenght"
     * )
     *
     * @var string
     */
    private string $note;

    /**
     * @Assert\NotNull(message="List ID can not be empty.")
     * @Assert\Uuid(message="List ID should be a valid UUID.")
     *
     * @var string
     * @Serializer\SerializedName("listId")
     */
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
