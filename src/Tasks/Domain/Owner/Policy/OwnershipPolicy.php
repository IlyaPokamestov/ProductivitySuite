<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Policy;

use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Ownerable;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\OwnershipIsNotDefinedException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\OwnershipMismatchException;

/**
 * Interface OwnershipPolicy
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner
 *
 * Ownership policy which is going with each interaction with the model.
 * Policy can decide does owner of the policy also owner of the Ownerable model or not.
 */
interface OwnershipPolicy
{
    /**
     * @param Ownerable $ownerable
     * @return void
     * @throws OwnershipIsNotDefinedException
     * @throws OwnershipMismatchException
     */
    public function verify(Ownerable $ownerable): void;
}
