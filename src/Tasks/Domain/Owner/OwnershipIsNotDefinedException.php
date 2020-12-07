<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\AuthorizationException;

/**
 * Class OwnershipIsNotDefinedException
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner
 *
 * Thrown in case when ownership policy can't detect who is the owner.
 */
class OwnershipIsNotDefinedException extends AuthorizationException
{
}
