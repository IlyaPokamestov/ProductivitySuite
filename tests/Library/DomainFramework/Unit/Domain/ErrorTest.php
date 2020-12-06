<?php declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Library\DomainFramework\Unit\Domain;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\DomainException;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\Error;
use PHPUnit\Framework\TestCase;

final class ErrorTest extends TestCase
{
    public function testExceptionWrapping(): void
    {
        $exception = new DomainException('error!');
        $error = Error::wrap($exception);

        $this->assertEquals('error!', $error->getMessage());
    }
}
