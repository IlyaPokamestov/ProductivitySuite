<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\QueryInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\FindByCriteriaTrait;

/**
 * Class FindListByCriteria
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query
 */
final class FindListByCriteria implements QueryInterface
{
    use FindByCriteriaTrait;
}
