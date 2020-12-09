<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Exception;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\AuthorizationException;

/**
 * Class OwnershipIsNotDefinedException
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Owner
 *
 * Thrown in case when ownership policy can't detect who is the owner.
 */
final class OwnershipIsNotDefinedException extends AuthorizationException
{
}
