<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Policy;

use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\OwnerId;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\OwnershipMismatchException;

/**
 * Interface OwnerRegisteredPolicy
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner\Policy
 *
 * Verifies that owner is fully registered in the system.
 * The business requirements for this policy may sounds like:
 * "Only user who completed the registration can create a new lists and tasks."
 */
interface OwnerRegisteredPolicy
{
    /**
     * @param OwnerId $owner
     * @return void
     * @throws OwnershipMismatchException
     */
    public function verify(OwnerId $owner): void;
}
