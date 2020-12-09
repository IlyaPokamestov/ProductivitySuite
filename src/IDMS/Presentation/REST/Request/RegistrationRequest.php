<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Presentation\REST\Request;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RegistrationRequest
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Presentation\REST\Request
 */
final class RegistrationRequest
{
    /**
     * @var string
     * @Assert\NotNull(message="Username can not be empty.")
     * @Assert\Length(
     *     min="1",
     *     max="50",
     *     minMessage="Username should be more than 1 character lenght",
     *     maxMessage="Username can not be more than 50 characters lenght"
     * )
     * @Assert\Regex(
     *     pattern="/^[A-Za-z0-9]*$/",
     *     message="Username should contain only numbers and letters."
     * )
     */
    private string $username;

    /**
     * @var string
     * @Assert\NotNull(message="First name can not be empty.")
     * @Assert\Length(
     *     min="1",
     *     max="150",
     *     minMessage="First name should be more than 1 character lenght",
     *     maxMessage="First name can not be more than 150 characters lenght"
     * )
     * @Serializer\SerializedName("firstName")
     */
    private string $firstName;

    /**
     * @var string
     * @Assert\NotNull(message="Last name can not be empty.")
     * @Assert\Length(
     *     min="1",
     *     max="150",
     *     minMessage="Last name should be more than 1 character lenght",
     *     maxMessage="Last name can not be more than 150 characters lenght"
     * )
     * @Serializer\SerializedName("lastName")
     */
    private string $lastName;

    /**
     * @var string
     * @Assert\Email()
     * @Assert\NotNull(message="Email can not be empty.")
     * @Assert\Length(
     *     min="1",
     *     max="150",
     *     minMessage="Email should be more than 1 character lenght",
     *     maxMessage="Email can not be more than 150 characters lenght"
     * )
     */
    private string $email;

    /**
     * RegistrationRequest constructor.
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
