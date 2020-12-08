<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller\Request;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MoveTaskRequest
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller\Request
 */
class MoveTaskRequest
{
    /**
     * @Assert\NotNull(message="List ID can not be empty.")
     * @Assert\Uuid(message="List ID should be a valid UUID.")
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
