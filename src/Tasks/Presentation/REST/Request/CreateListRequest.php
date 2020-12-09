<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Request;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CreateListRequest
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Request
 */
final class CreateListRequest
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
