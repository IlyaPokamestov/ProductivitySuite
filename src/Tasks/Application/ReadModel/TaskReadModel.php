<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class TaskReadModel
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\ReadModel
 */
class TaskReadModel
{
    /** @var string */
    private string $id;

    /**
     * @var string
     * @Serializer\SerializedName("title")
     */
    private string $title;

    /**
     * @var ?string
     * @Serializer\SerializedName("listId")
     */
    private ?string $listId;

    /**
     * Task constructor.
     * @param string $id
     * @param string $title
     * @param ?string $listId
     */
    public function __construct(string $id, string $title, ?string $listId = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->listId = $listId;
    }
}
