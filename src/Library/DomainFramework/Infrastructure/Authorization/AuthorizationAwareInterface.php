<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Authorization;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Authorization\AuthorizationContextInterface;

/**
 * Interface AuthorizationAwareInterface
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Authorization
 */
interface AuthorizationAwareInterface
{
    /**
     * @param AuthorizationContextInterface $authorizationContext
     */
    public function setAuthorizationContext(AuthorizationContextInterface $authorizationContext);
}
