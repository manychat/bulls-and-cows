<?php

declare(strict_types=1);

namespace Test\Unit;

use PHPUnit\Framework\TestCase;

final class YoTest extends TestCase
{
    public function testSuccess(): void
    {
        self::assertEquals(1, 1);
    }
}
