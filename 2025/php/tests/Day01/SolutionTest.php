<?php

declare(strict_types=1);

namespace Tests\Day01;

use AoC\Day01\Solution;
use PHPUnit\Framework\TestCase;

final class SolutionTest extends TestCase
{
    public function testDialRotate(): void
    {
        $solution = new Solution();

        $result = $solution->rotate(11, 'R8');
        self::assertSame(19, $result);

        $result = $solution->rotate(19, 'L19');
        self::assertSame(0, $result);

        $result = $solution->rotate(5, 'L10');
        self::assertSame(95, $result);

        $result = $solution->rotate(95, 'R5');
        self::assertSame(0, $result);
    }
}
