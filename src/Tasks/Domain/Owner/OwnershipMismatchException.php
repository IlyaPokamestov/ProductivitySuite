<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\AccessDeniedException;

/**
 * Class OwnershipMismatchException
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner
 *
 * Thrown in case when owner or the model not matching with who is trying to get an access.
 */
class OwnershipMismatchException extends AccessDeniedException
{
}
