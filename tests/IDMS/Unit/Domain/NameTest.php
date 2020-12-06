<?php declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\IDMS\Unit\Domain;

use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Name;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testValidName(): void
    {
        $name = new Name('IlyaPokamestov', 'Ilya', 'Pokamestov');

        $this->assertInstanceOf(Name::class, $name);
    }

    public function testInValidUsername(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Name('', 'Ilya', 'Pokamestov');
    }

    public function testInValidFirstName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Name('IlyaPokamestov', '', 'Pokamestov');
    }

    public function testInValidLastName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Name('IlyaPokamestov', 'Ilya', '');
    }
}
