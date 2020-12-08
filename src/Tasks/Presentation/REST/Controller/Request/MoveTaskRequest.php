<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller\Request;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class MoveTaskRequest
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller\Request
 */
class MoveTaskRequest
{
    /**
     * @Serializer\SerializedName("listId")
     *
     * @var string
     */
    private string $listId;

    /**
     * @return string
     */
    public function getListId(): string
    {
        return $this->listId;
    }
}
