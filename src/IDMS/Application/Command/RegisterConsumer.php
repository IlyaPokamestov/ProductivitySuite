<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Application\Command;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RegisterConsumer
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Application\Command
 */
class RegisterConsumer
{
    /**
     * @var string
     * @Assert\NotNull()
     * @Assert\Length(
     *     min="1",
     *     max="50"
     * )
     * @Assert\Regex(
     *     pattern="/^[A-Za-z0-9]*$/",
     *     message="Username should contain only numbers and letters."
     * )
     */
    private string $username;

    /**
     * @var string
     * @Assert\NotNull()
     * @Assert\Length(
     *     min="1",
     *     max="150"
     * )
     * @Serializer\SerializedName("firstName")
     */
    private string $firstName;

    /**
     * @var string
     * @Assert\NotNull()
     * @Assert\Length(
     *     min="1",
     *     max="150"
     * )
     * @Serializer\SerializedName("lastName")
     */
    private string $lastName;

    /**
     * @var string
     * @Assert\Email()
     * @Assert\NotNull()
     * @Assert\Length(
     *     min="1",
     *     max="150"
     * )
     */
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
