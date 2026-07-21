<?php

declare(strict_types=1);

namespace Tests\Day01;

use AoC\common\Input;
use AoC\Day01\Solver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class SolverTest extends TestCase
{
    public static function rotationData(): array
    {
        return [
            [11, 'R8',   19],
            [19, 'L19',  0],
            [05, 'L10',  95],
            [95, 'R5',   0],
            [00, 'R101', 1],
            [50, 'L50',  0],
            [50, 'L68',  82],
            [20, 'R201', 21],
        ];
    }

    public static function fullZeroCountData(): array
    {
        return [
            [00, 'R101', 1,  1],
            [95, 'R60',  55, 1],
            [55, 'L55',  0,  0],
            [82, 'L30',  52, 0],
            [14, 'L82',  32, 1],
            [20, 'R201', 21, 2],
        ];
    }

    #[DataProvider('rotationData')]
    public function testDialRotate(int $position, string $rotation, int $expected): void
    {
        $solution = new Solver();

        $result = $solution->rotate($position, $rotation);
        self::assertSame($expected, $result);
    }

    #[DataProvider('fullZeroCountData')]
    public function testDialFullRotateCount(
        int $position,
        string $rotation,
        int $expectedPosition,
        int $expectedCount
    ): void {
        $solution = new Solver();

        ['position' => $result, 'fullRotationCount' => $count] = $solution->rotateWithZeroCount($position, $rotation);
        self::assertSame($expectedPosition, $result);
        self::assertSame($expectedCount, $count);
    }

    public function testGetCode(): void
    {
        $basePath = dirname(__DIR__, 3) . '/__examples';
        $input = new Input($basePath);

        $rotations = $input->forDay(1);
        $solution = new Solver();

        $result = $solution->getCode($rotations);
        self::assertSame(3, $result);
    }
}
