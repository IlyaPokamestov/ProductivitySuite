<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Request;

use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Ownerable;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\OwnershipIsNotDefinedException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\OwnershipMismatchException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Policy\OwnershipPolicy;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class RequestBasedOwnershipPolicy
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Presentation\REST\Request
 */
class RequestBasedOwnershipPolicy implements OwnershipPolicy
{
    private const OWNER_ID_HEADER = 'X-Authorized-Consumer-ID';

    /** @var RequestStack */
    private RequestStack $stack;

    /**
     * RequestBasedOwnershipPolicy constructor.
     * @param RequestStack $stack
     */
    public function __construct(RequestStack $stack)
    {
        $this->stack = $stack;
    }

    /** {@inheritDoc} */
    public function verify(Ownerable $ownerable): void
    {
        $request = $this->stack->getMasterRequest();
        if (!$request->headers->has(self::OWNER_ID_HEADER)) {
            throw new OwnershipIsNotDefinedException('Consumer is not authorized!');
        }

        if (
            (string) $ownerable->getOwnerId() !==
            $request->headers->get(self::OWNER_ID_HEADER)
        ) {
            throw new OwnershipMismatchException('Access denied!');
        }
    }
}
