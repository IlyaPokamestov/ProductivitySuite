<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Service;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Authorization\AuthorizationContextInterface;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Model\Owner\Ownerable;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Exception\OwnershipMismatchException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Policy\OwnershipPolicy;

/**
 * Class AuthorizationBasedOwnershipPolicy
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Infrastructure\Service
 */
class AuthorizationBasedOwnershipPolicy implements OwnershipPolicy
{
    /** @var AuthorizationContextInterface */
    private AuthorizationContextInterface $authorizationContext;

    /**
     * AuthorizationBasedOwnershipPolicy constructor.
     * @param AuthorizationContextInterface $authorizationContext
     */
    public function __construct(AuthorizationContextInterface $authorizationContext)
    {
        $this->authorizationContext = $authorizationContext;
    }

    /** {@inheritDoc} */
    public function verify(Ownerable $ownerable): void
    {
        $requesterId = $this->authorizationContext->getRequesterId();
        if ((string) $ownerable->getOwnerId() !== $requesterId) {
            throw new OwnershipMismatchException('Access denied!');
        }
    }
}
