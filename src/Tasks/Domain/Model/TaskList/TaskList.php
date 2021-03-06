<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\EventRecorderInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\EventRecorderTrait;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Assert;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Removable;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\RemovableTrait;
use Doctrine\ORM\Mapping as ORM;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\Event\ListCreated;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\Event\ListRemoved;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Owner\Ownerable;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Owner\OwnerableTrait;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Owner\OwnerId;

/**
 * Class TaskList
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList
 *
 * List aggregate root.
 * PHP does not allow to call class List at the moment, probably this is changed in PHP ^8.0
 *
 * @ORM\Entity()
 * @ORM\Table(name="list")
 */
class TaskList implements EventRecorderInterface, Removable, Ownerable
{
    use EventRecorderTrait;
    use RemovableTrait;
    use OwnerableTrait;

    public const DEFAULT_LIST_NAME = 'Tasks';

    /**
     * @ORM\Id()
     * @ORM\Column(type="list_id")
     *
     * @var ListId
     */
    private ListId $id;

    /**
     * @ORM\Column(type="string", length=150)
     *
     * @var string
     */
    private string $name;

    /**
     * @param ListId $id
     * @param string $name
     * @param OwnerId $owner
     * @return static
     */
    public static function create(ListId $id, string $name, OwnerId $owner): self
    {
        return new static($id, $name, $owner);
    }

    /**
     * List constructor.
     * @param ListId $id
     * @param string $name
     * @param OwnerId $owner
     */
    final public function __construct(ListId $id, string $name, OwnerId $owner)
    {
        Assert::stringNotEmpty($name, 'Name can not be empty!');

        $this->id = $id;
        $this->name = $name;
        $this->ownerId = $owner;

        $this->record(new ListCreated((string) $id, $name, (string) $owner));
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
