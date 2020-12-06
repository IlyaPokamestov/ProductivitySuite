<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\TaskList;

/**
 * Class CreateList
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command
 */
class CreateList
{
    /** @var string */
    private string $name;

    /**
     * CreateList constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
