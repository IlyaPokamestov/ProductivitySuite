<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Domain;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Assert;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Name
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Domain
 *
 * VO which represents consumer name.
 *
 * @ORM\Embeddable
 */
final class Name
{
    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private string $username;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private string $lastName;

    /**
     * Name constructor.
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $username, string $firstName, string $lastName)
    {
        Assert::stringNotEmpty($username, 'Username should be a non empty string.');
        Assert::stringNotEmpty($firstName, 'First name should be a non empty string.');
        Assert::stringNotEmpty($lastName, 'Last name should be a non empty string.');

        $this->username = $username;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
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
}
