<?php declare(strict_types=1);

namespace IlyaPokamestov\ProductivitySuite\Tests\IDMS\Unit;

use PHPUnit\Framework\TestCase;

final class AlwaysSuccessTest extends TestCase
{
    public function testOnTrue(): void
    {
        $this->assertTrue(true);
    }
}
