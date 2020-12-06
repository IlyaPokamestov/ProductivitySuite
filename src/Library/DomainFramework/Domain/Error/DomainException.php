<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error;

/**
 * Class DomainException
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error
 *
 * Base domain error, should be thrown in case of business rules violation.
 */
class DomainException extends \DomainException
{
}
