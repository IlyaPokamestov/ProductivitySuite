<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\AggregateRoot;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Removable;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\RemovableTrait;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Events\TaskCreated;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Events\TaskMoved;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Events\TaskRemoved;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Events\TaskUpdated;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\TaskList\ListId;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Task
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task
 *
 * @ORM\Entity()
 * @ORM\Table(name="task")
 */
class Task extends AggregateRoot implements Removable
{
    use RemovableTrait;

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
     * @param TaskId $id
     * @param ListId $listId
     * @param Description $description
     * @return static
     */
    public static function create(TaskId $id, ListId $listId, Description $description): self
    {
        return new static($id, $listId, $description);
    }

    /**
     * Task constructor.
     * @param TaskId $id
     * @param ListId $listId
     * @param Description $description
     */
    final public function __construct(TaskId $id, ListId $listId, Description $description)
    {
        $this->id = $id;
        $this->listId = $listId;
        $this->description = $description;

        $this->record(new TaskCreated(
            (string) $id,
            (string) $listId,
            $description->getTitle(),
            $description->getNote()
        ));
    }

    /**
     * Update description of the task.
     *
     * @param Description $description
     */
    public function update(Description $description): void
    {
        $this->description = $description;

        $this->record(new TaskUpdated(
            (string) $this->id,
            $description->getTitle(),
            $description->getNote()
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
