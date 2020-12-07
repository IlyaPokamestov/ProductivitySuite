<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\AggregateRoot;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Assert;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Removable;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\RemovableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TaskList
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList
 *
 * List aggregate root.
 * PHP does not allow to call class List at the moment, probably this is changed in PHP ^8.0
 *
 * @ORM\Entity()
 * @ORM\Table(name="list")
 */
class TaskList extends AggregateRoot implements Removable
{
    use RemovableTrait;

    /**
     * @ORM\Id()
     * @ORM\Column(type="list_id")
     *
     * @var ListId
     */
    private ListId $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
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
    final public function __construct(ListId $id, string $name)
    {
        Assert::stringNotEmpty($name, 'Name can not be empty!');

        $this->id = $id;
        $this->name = $name;

        $this->record(new ListCreated((string) $id, $name));
    }

    /**
     * @return ListId
     */
    public function getId(): ListId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
