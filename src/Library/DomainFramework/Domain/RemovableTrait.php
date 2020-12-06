<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain;

/**
 * Trait RemovableTrait
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain
 */
trait RemovableTrait
{
    /** @var bool */
    protected bool $removed = false;

    /** @return bool */
    public function isRemoved(): bool
    {
        return $this->removed;
    }
}
