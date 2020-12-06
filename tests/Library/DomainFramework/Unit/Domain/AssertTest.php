<?php declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Library\DomainFramework\Unit\Domain;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Assert;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class AssertTest extends TestCase
{
    public function testCustomException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Assert::string([]);
    }
}
