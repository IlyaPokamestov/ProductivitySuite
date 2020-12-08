<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller\Request;

/**
 * Class CompleteTaskRequest
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Controller\Request
 */
class CompleteTaskRequest
{
    /** @var bool */
    private bool $completed = false;

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->completed;
    }
}
