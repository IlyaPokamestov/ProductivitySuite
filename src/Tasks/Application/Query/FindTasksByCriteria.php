<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\QueryInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\FindByCriteriaTrait;

/**
 * Class FindTasksByCriteria
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query
 */
final class FindTasksByCriteria implements QueryInterface
{
    use FindByCriteriaTrait;
}
