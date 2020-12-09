<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\InvalidArgumentException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ThrowValidationError
 * @package IlyaPokamestov\ProductivitySuite\Library\ApplicationFramework
 *
 * Convert other exception/error types to domain one and throw a domain error
 */
class ThrowValidationError
{
    /** @param ConstraintViolationListInterface $list */
    public static function fromConstraintViolation(ConstraintViolationListInterface $list): void
    {
        if (count($list) > 0) {
            throw new InvalidArgumentException($list->get(0)->getMessage());
        }
    }
}
