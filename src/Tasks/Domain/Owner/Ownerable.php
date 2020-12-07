<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Domain\Owner;

/**
 * Interface Ownerable
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Domain
 *
 * Indicate that instance of the model has owner.
 */
interface Ownerable
{
    /**
     * Returns owner id of the model.
     *
     * @return OwnerId
     */
    public function getOwnerId(): OwnerId;
}
