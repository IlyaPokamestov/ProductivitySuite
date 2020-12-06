<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error;

/**
 * Class DomainException
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error
 *
 * Should be thrown in case when not valid input parameters are passed to the domain model.
 */
class InvalidArgumentException extends \InvalidArgumentException
{
}
