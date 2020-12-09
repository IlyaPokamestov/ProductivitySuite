<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Authorization;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\AuthorizationException;

/**
 * Interface AuthorizationContextInterface
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Authorization
 */
interface AuthorizationContextInterface
{
    /**
     * Returns string representation of the requester ID.
     *
     * @return string
     * @throws AuthorizationException
     */
    public function getRequesterId(): string;
}
