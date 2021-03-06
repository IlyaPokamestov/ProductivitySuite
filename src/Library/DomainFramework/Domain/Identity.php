<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain;

use Ramsey\Uuid\Uuid;

/**
 * Class Identity
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain
 */
class Identity
{
    /** @var string|null */
    private static ?string $next = null;

    /** @var string */
    private string $id;

    /**
     * Generate identity.
     *
     * @return static
     */
    public static function generate(): self
    {
        $id = static::$next;
        if (null === $id) {
            $id = Uuid::uuid4()->toString();
        }

        return new static($id);
    }

    /**
     * Generate identity.
     *
     * @return string
     */
    public static function next(): string
    {
        static::$next = Uuid::uuid4()->toString();

        return static::$next;
    }

    /**
     * Identity constructor.
     * @param string $id
     */
    final public function __construct(string $id)
    {
        Assert::uuid($id, 'ID is invalid.');

        $this->id = $id;
    }

    /** @return string */
    public function id(): string
    {
        return $this->id;
    }

    /** @return string */
    public function __toString(): string
    {
        return $this->id();
    }
}
