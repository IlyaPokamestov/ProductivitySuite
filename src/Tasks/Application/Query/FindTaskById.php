<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tasks\Application\Query;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\QueryInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\FindById as Base;

/**
 * Class FindTaskById
 * @package IlyaPokamestov\ProductivitySuite\Tasks\Application\Query
 */
final class FindTaskById extends Base implements QueryInterface
{
}
