<?php declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\IDMS\Unit\Domain;

use IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\Name;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testValidName(): void
    {
        $name = new \IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\Name('IlyaPokamestov', 'Ilya', 'Pokamestov');

        $this->assertInstanceOf(\IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\Name::class, $name);
    }

    public function testInValidUsername(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new \IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\Name('', 'Ilya', 'Pokamestov');
    }

    public function testInValidFirstName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new \IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\Name('IlyaPokamestov', '', 'Pokamestov');
    }

    public function testInValidLastName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new \IlyaPokamestov\ProductivitySuite\IDMS\Domain\Model\Consumer\Name('IlyaPokamestov', 'Ilya', '');
    }
}
