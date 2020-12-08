<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Error
 * @package IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error
 */
class Error
{
    /**
     * @Serializer\Type("string")
     *
     * @var string
     */
    private string $message;

    /**
     * @param DomainException $exception
     * @return static
     */
    public static function wrap(DomainException $exception): self
    {
        return new static($exception->getMessage());
    }

    /**
     * Error constructor.
     * @param string $message
     */
    final public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
