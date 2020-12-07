<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\IDMS\Domain;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Assert;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Status
 * @package IlyaPokamestov\ProductivitySuite\IDMS\Domain
 *
 * VO which represents consumer status.
 *
 * @ORM\Embeddable
 */
final class Status
{
    private const REGISTRATION_IN_PROGRESS = 'REGISTRATION_IN_PROGRESS';
    private const ACTIVE = 'ACTIVE';

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private string $status;

    /** @return static */
    public static function registrationInProgress(): self
    {
        return new static(self::REGISTRATION_IN_PROGRESS);
    }

    /** @return static */
    public static function active(): self
    {
        return new static(self::ACTIVE);
    }

    /**
     * Status constructor.
     * @param string $status
     *
     * @throws InvalidArgumentException
     */
    final public function __construct(string $status)
    {
        Assert::oneOf(
            $status,
            [ self::REGISTRATION_IN_PROGRESS, self::ACTIVE ],
            'Status unknown!'
        );

        $this->status = $status;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->status;
    }

    /**
     * @param Status $status
     * @return bool
     */
    public function equal(Status $status): bool
    {
        return $this->status === (string) $status;
    }
}
