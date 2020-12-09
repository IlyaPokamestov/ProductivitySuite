<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\CommandInterface;

/**
 * Class CompleteTask
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command
 */
final class CompleteTask implements CommandInterface
{
    /** @var string */
    private string $id;

    /**
     * CompleteTask constructor.
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
