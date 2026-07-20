<?php

declare(strict_types=1);

namespace Tests\Day01;

use AoC\Day01\Solver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class SolverTest extends TestCase
{
    public static function additionProvider(): array
    {
        return [
            [11, 'R8',  19],
            [19, 'L19',  0],
            [5,  'L10', 95],
            [95, 'R5',   0],
        ];
    }

    #[DataProvider('additionProvider')]
    public function testDialRotate(int $position, string $rotation, int $expected): void
    {
        $solution = new Solver();

        $result = $solution->rotate($position, $rotation);
        self::assertSame($expected, $result);
    }
}
