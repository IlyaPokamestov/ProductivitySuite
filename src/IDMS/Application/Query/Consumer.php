<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Application\Query;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Consumer
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Application\Query
 *
 * Read model: consumer representation.
 */
class Consumer
{
    /** @var string */
    private string $id;
    /** @var string */
    private string $username;

    /**
     * @var string
     * @Serializer\SerializedName("firstName")
     */
    private string $firstName;

    /**
     * @var string
     * @Serializer\SerializedName("lastName")
     */
    private string $lastName;

    /** @var string */
    private string $email;

    /**
     * @Serializer\Exclude()
     *
     * @var string
     */
    private string $status;

    /**
     * Consumer constructor.
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
    public function getStatus(): string
    {
        return $this->status;
    }
}
