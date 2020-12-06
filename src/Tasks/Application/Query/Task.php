<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Task
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query
 */
class Task
{
    /** @var string */
    private string $id;
    /**
     * @var string
     * @Serializer\SerializedName("name")
     */
    private string $title;

    /**
     * Task constructor.
     * @param string $id
     * @param string $title
     */
    public function __construct(string $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }
}
