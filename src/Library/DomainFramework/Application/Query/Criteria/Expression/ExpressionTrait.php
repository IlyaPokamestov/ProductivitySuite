<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\Criteria\Expression;

/**
 * Class ExpressionTrait
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query\Criteria\Expression
 */
trait ExpressionTrait
{
    /** @var string */
    private string $field;
    /** @var mixed */
    private $value;

    /**
     * ExpressionTrait constructor.
     * @param string $field
     * @param mixed $value
     */
    public function __construct(string $field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
