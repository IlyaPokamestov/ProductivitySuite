<?php

declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Tasks\Unit\Domain\Task;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Error\InvalidArgumentException;
use IlyaPokamestov\ProductivitySuite\Tasks\Domain\Task\Description;
use IlyaPokamestov\ProductivitySuite\Tests\RandomString;
use PHPUnit\Framework\TestCase;

class DescriptionTest extends TestCase
{
    public function testCreation()
    {
        $description = new Description('Do that!', 'now!');

        $this->assertInstanceOf(Description::class, $description);
        $this->assertEquals('Do that!', $description->getTitle());
        $this->assertEquals('now!', $description->getNote());
    }

    public function testLongTitle()
    {
        $this->expectException(InvalidArgumentException::class);

        new Description(RandomString::string(151));
    }

    public function testLongNote()
    {
        $this->expectException(InvalidArgumentException::class);

        new Description('Do that!', RandomString::string(1001));
    }
}
