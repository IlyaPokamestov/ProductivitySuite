<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Application\Query;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Messaging\QueryInterface;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\FindByIdTrait;

/**
 * Class FindConsumerById
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Application\Query
 */
final class FindConsumerById implements QueryInterface
{
    use FindByIdTrait;
}
