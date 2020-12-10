<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query;

/**
 * Interface PaginationInterface
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query
 */
interface PaginationInterface
{
    public const LIMIT_DEFAULT = 20;
    public const LIMIT_MAX = 20;
    public const OFFSET_DEFAULT = 0;
}
