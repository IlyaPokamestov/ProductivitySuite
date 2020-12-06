<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Application\Command;

class RegisterConsumer
{
    /** @var string */
    private string $username;
    /** @var string */
    private string $firstName;
    /** @var string */
    private string $lastName;
    /** @var string */
    private string $email;

    /**
     * RegisterConsumer constructor.
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     */
    public function __construct(string $username, string $firstName, string $lastName, string $email)
    {
        $this->username = $username;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
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
}
