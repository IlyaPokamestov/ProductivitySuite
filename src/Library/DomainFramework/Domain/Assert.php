<?php

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\InvalidArgumentException;
use Webmozart\Assert\Assert as BaseAssert;

/**
 * Class Assert
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain
 *
 * We need to have some library to check input data. And we need this library to throw our type of exception.
 */
class Assert extends BaseAssert
{
    /**
     * Replace default exception with our domain exception.
     *
     * @param string $message
     */
    public static function reportInvalidArgument($message)
    {
        throw new InvalidArgumentException($message);
    }
}
