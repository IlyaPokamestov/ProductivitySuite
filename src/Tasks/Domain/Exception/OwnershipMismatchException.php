<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Exception;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\AccessDeniedException;

/**
 * Class OwnershipMismatchException
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Owner
 *
 * Thrown in case when owner or the model not matching with who is trying to get an access.
 */
final class OwnershipMismatchException extends AccessDeniedException
{
}
