<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Authorization;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Authorization\AuthorizationContextInterface;

/**
 * Trait AuthorizationAwareTrait
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Authorization
 */
trait AuthorizationAwareTrait
{
    /** @var AuthorizationContextInterface */
    protected AuthorizationContextInterface $authorizationContext;

    /**
     * @param AuthorizationContextInterface $authorizationContext
     */
    public function setAuthorizationContext(AuthorizationContextInterface $authorizationContext): void
    {
        $this->authorizationContext = $authorizationContext;
    }
}
