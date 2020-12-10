<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\Criteria;

/**
 * Interface ExpressionInterface
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query
 */
interface ExpressionInterface
{
    /**
     * Returns field name.
     *
     * @return string
     */
    public function getField(): string;

    /**
     * Returns value of the field.
     *
     * @return mixed
     */
    public function getValue();
}
