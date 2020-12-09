<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\Event;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\EventInterface;

/**
 * Class ConsumerRegistered
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Domain
 *
 * Event shouldn't include only primitives by two reasons:
 * - events can be transmitted over the network and should be serializable.
 * (but it's of course possible to serialize objects)
 * - other bounded contexts which listed those event's shouldn't depend on the events from another bounded context
 */
final class RegistrationInitiated implements EventInterface
{
    /** @var string */
    private string $id;
    /** @var string */
    private string $username;
    /** @var string */
    private string $firstName;
    /** @var string */
    private string $lastName;
    /** @var string */
    private string $email;
    /** @var string */
    private string $status;

    /**
     * ConsumerRegistered constructor.
     * @param string $id
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $status
     */
    public function __construct(
        string $id,
        string $username,
        string $firstName,
        string $lastName,
        string $email,
        string $status
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
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
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
