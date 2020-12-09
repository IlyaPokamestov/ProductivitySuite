<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Application\Command;

use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\ConsumerId;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\CommandInterface;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RegisterConsumer
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Application\Command
 */
final class RegisterConsumer implements CommandInterface
{
    /** @var ConsumerId */
    private ConsumerId $id;

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
     * RegisterConsumer constructor.
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     */
    public function __construct(string $username, string $firstName, string $lastName, string $email)
    {
        $this->id = ConsumerId::generate();
        $this->username = $username;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }

    /**
     * @return ConsumerId
     */
    public function getId(): ConsumerId
    {
        //TODO: Switch controllers to RequestsDTO's
        if (!isset($this->id)) {
            $this->id = ConsumerId::generate();
        }

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
}
