<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Request;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CompleteTaskRequest
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Request
 */
final class CompleteTaskRequest
{
    /**
     * @Assert\NotNull(message="Completed can not be empty.")
     * @Assert\Type(type="bool", message="Completed should be a boolean.")
     *
     * @var bool
     */
    private bool $completed = false;

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->completed;
    }
}
