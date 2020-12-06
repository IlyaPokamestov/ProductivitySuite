<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\AggregateRoot;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Assert;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Removable;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\RemovableTrait;

class TaskList extends AggregateRoot implements Removable
{
    use RemovableTrait;

    /** @var ListId */
    private ListId $id;
    /** @var string */
    private string $name;

    /**
     * @param ListId $id
     * @param string $name
     * @return static
     */
    public static function create(ListId $id, string $name): self
    {
        return new static($id, $name);
    }

    /**
     * TaskList constructor.
     * @param ListId $id
     * @param string $name
     */
    public function __construct(ListId $id, string $name)
    {
        Assert::stringNotEmpty($name, 'Name can not be empty!');

        $this->id = $id;
        $this->name = $name;

        $this->record(new ListCreated((string) $id, $name));
    }

    /**
     * Remove list.
     */
    public function remove(): void
    {
        $this->removed = true;
        $this->record(new ListRemoved((string) $this->id));
    }
}
