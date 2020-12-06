<?php declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\IDMS\Unit\Domain;

use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Email;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testValidEmail(): void
    {
        $email = new Email('test@test.com');

        $this->assertInstanceOf(Email::class, $email);
    }

    public function testInValidEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Email('test');
    }
}
