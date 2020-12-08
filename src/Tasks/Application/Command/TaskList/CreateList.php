<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Command\TaskList;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CreateList
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Command
 */
class CreateList
{
    /**
     * @Assert\NotNull(message="Name can not be empty.")
     * @Assert\Length(
     *     min="1",
     *     max="150",
     *     minMessage="Name should be more than 1 character lenght",
     *     maxMessage="Name can not be more than 150 characters lenght"
     * )
     *
     * @var string
     */
    private string $name;

    /**
     *
     * @Assert\NotNull(message="Owner ID can not be empty.")
     * @Assert\Uuid(message="Owner ID should be a valid UUID.")
     *
     * @var string
     * @Serializer\SerializedName("ownerId")
     *
     * @var string
     */
    private string $ownerId;

    /**
     * CreateList constructor.
     * @param string $name
     * @param string $ownerId
     */
    public function __construct(string $name, string $ownerId)
    {
        $this->name = $name;
        $this->ownerId = $ownerId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getOwnerId(): string
    {
        return $this->ownerId;
    }
}
