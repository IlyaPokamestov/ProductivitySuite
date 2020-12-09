<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\EventRecorderInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\EventRecorderTrait;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Removable;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\RemovableTrait;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Owner\Ownerable;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Owner\OwnerableTrait;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Owner\OwnerId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Event\TaskCreated;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Event\TaskMoved;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Event\TaskRemoved;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task\Event\TaskCompleted;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\TaskList\ListId;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Task
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Task
 *
 * @ORM\Entity()
 * @ORM\Table(name="task", indexes={@ORM\Index(name="search_idx", columns={"list_id", "completed"})})
 */
class Task implements EventRecorderInterface, Removable, Ownerable
{
    use EventRecorderTrait;
    use RemovableTrait;
    use OwnerableTrait;

    /**
     * @ORM\Id()
     * @ORM\Column(type="task_id")
     *
     * @var TaskId
     */
    private TaskId $id;

    /**
     * @ORM\Column(type="list_id")
     *
     * @var ListId
     */
    private ListId $listId;

    /**
     * @ORM\Embedded(class = "Description")
     *
     * @var Description
     */
    private Description $description;

    /**
     * @ORM\Column(type="boolean", options={"default":"0"})
     *
     * @var bool
     */
    private bool $completed = false;

    /**
     * @param TaskId $id
     * @param ListId $listId
     * @param Description $description
     * @param OwnerId $ownerId
     * @return static
     */
    public static function create(TaskId $id, ListId $listId, Description $description, OwnerId $ownerId): self
    {
        return new static($id, $listId, $description, $ownerId);
    }

    /**
     * Task constructor.
     * @param TaskId $id
     * @param ListId $listId
     * @param Description $description
     * @param OwnerId $ownerId
     */
    final public function __construct(TaskId $id, ListId $listId, Description $description, OwnerId $ownerId)
    {
        $this->id = $id;
        $this->listId = $listId;
        $this->description = $description;
        $this->ownerId = $ownerId;

        $this->record(new TaskCreated(
            (string) $id,
            (string) $listId,
            $description->getTitle(),
            $description->getNote(),
            (string) $ownerId
        ));
    }

    /**
     * Complete Task
     */
    public function complete(): void
    {
        $this->completed = true;

        $this->record(new TaskCompleted(
            (string) $this->id,
        ));
    }

    /**
     * Move task to another list.
     *
     * @param ListId $newListId
     */
    public function move(ListId $newListId): void
    {
        $this->listId = $newListId;

        $this->record(new TaskMoved(
            (string) $this->id,
            (string) $newListId
        ));
    }

    /**
     * Remove task.
     */
    public function remove(): void
    {
        $this->removed = true;
        $this->record(new TaskRemoved((string) $this->id));
    }

    /**
     * @return TaskId
     */
    public function getId(): TaskId
    {
        return $this->id;
    }

    /**
     * @return ListId
     */
    public function getListId(): ListId
    {
        return $this->listId;
    }

    /**
     * @return Description
     */
    public function getDescription(): Description
    {
        return $this->description;
    }
}
