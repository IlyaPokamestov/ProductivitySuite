<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\Event;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Event;

/**
 * Class RegistrationCompleted
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Domain
 */
final class RegistrationCompleted implements Event
{
    /** @var string */
    private string $id;
    /** @var string */
    private string $status;

    /**
     * RegistrationCompleted constructor.
     * @param string $id
     * @param string $status
     */
    public function __construct(string $id, string $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
