<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Authorization;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Authorization\AuthorizationContextInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\AuthorizationException;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class RequestAuthorizationContext
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Infrastructure\Service
 */
final class RequestAuthorizationContext implements AuthorizationContextInterface
{
    private const REQUESTER_ID_HEADER = 'X-Authorized-Consumer-ID';

    /** @var RequestStack */
    private RequestStack $stack;

    /**
     * RequestAuthorizationContext constructor.
     * @param RequestStack $stack
     */
    public function __construct(RequestStack $stack)
    {
        $this->stack = $stack;
    }

    /** {@inheritdoc} */
    public function getRequesterId(): string
    {
        $request = $this->stack->getMasterRequest();
        if (!$request->headers->has(self::REQUESTER_ID_HEADER)) {
            throw new AuthorizationException('Consumer is not authorized!');
        }

        return $request->headers->get(self::REQUESTER_ID_HEADER);
    }
}
