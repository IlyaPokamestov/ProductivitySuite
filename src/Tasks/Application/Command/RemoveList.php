<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\CommandInterface;

/**
 * Class RemoveList
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command
 */
final class RemoveList implements CommandInterface
{
    /** @var string */
    private string $id;

    /**
     * RemoveList constructor.
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
