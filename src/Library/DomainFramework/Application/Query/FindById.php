<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query;

/**
 * Class FindById
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Application\Query
 */
class FindById
{
    /** @var string */
    protected string $id;

    /**
     * FindById constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
