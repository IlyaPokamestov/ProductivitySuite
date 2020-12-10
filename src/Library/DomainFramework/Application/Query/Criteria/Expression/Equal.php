<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\Criteria\Expression;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\Criteria\ExpressionInterface;

/**
 * Class Equal
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\Criteria\Expression
 */
class Equal implements ExpressionInterface
{
    use ExpressionTrait;
}
