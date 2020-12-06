<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList;

/**
 * Class FindById
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query\TaskList
 */
class FindById
{
    /** @var string */
    private string $id;

    /**
     * FindById constructor.
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
