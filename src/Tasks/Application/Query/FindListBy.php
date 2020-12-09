<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\QueryInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\FindByCriteria;

/**
 * Class FindListBy
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query
 */
final class FindListBy extends FindByCriteria implements QueryInterface
{
}
