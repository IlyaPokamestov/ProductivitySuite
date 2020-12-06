<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Domain;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Assert;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\InvalidArgumentException;

/**
 * Class Email
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Domain
 *
 * VO which represents consumer email.
 */
final class Email
{
    /** @var string */
    private string $email;

    /**
     * Email constructor.
     * @param string $email
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $email)
    {
        Assert::email($email, 'Email is invalid.');

        $this->email = $email;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->email;
    }
}
