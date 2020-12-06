<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain;

/**
 * Interface Removable
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain
 */
interface Removable
{
    /**
     * Indicates does entity was removed or not.
     *
     * @return bool
     */
    public function isRemoved(): bool;
}
