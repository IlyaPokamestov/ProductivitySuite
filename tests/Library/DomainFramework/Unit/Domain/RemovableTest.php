<?php declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\Library\DomainFramework\Unit\Domain;

use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\Removable;
use IlyaPokamestov\ProductivitySuite\Library\DomainFramework\Domain\RemovableTrait;
use PHPUnit\Framework\TestCase;

final class RemovableTest extends TestCase
{
    public function testRemovable(): void
    {
        $removable = new class implements Removable {
            use RemovableTrait;

            /** @param bool $removed */
            public function setRemoved(bool $removed): void
            {
                $this->removed = $removed;
            }
        };

        $this->assertFalse($removable->isRemoved());
        $removable->setRemoved(true);
        $this->assertTrue($removable->isRemoved());
    }
}
