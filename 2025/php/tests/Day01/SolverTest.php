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
            // Примеры из условия.
            [11, 'R8', 19],
            [19, 'L19', 0],
            [5, 'L10', 95],
            [95, 'R5', 0],
            [50, 'L68', 82],

            // Переходы через границу диска.
            [0, 'L1', 99],
            [99, 'R1', 0],
            [2, 'L5', 97],
            [98, 'R5', 3],

            // Полные обороты.
            [0, 'R100', 0],
            [0, 'L100', 0],
            [37, 'R100', 37],
            [37, 'L100', 37],
            [50, 'R1000', 50],
            [50, 'L1000', 50],

            // Расстояния больше размера диска.
            [0, 'R101', 1],
            [0, 'L101', 99],
            [20, 'R201', 21],
            [20, 'L201', 19],
            [37, 'L437', 0],
            [37, 'R263', 0],

            // Вращения ровно до нуля.
            [50, 'R50', 0],
            [50, 'L50', 0],
            [1, 'L1', 0],
        ];
    }

    public static function fullZeroCountData(): array
    {
        return [
            // Начальная позиция 0 сама по себе не учитывается:
            // учитываются только позиции после кликов.
            [0, 'L1', 99, 0],
            [0, 'R1', 1, 0],

            // Конечная позиция 0 должна учитываться.
            [55, 'L55', 0, 1],
            [95, 'R5', 0, 1],
            [50, 'L50', 0, 1],
            [50, 'R50', 0, 1],
            [1, 'L1', 0, 1],
            [99, 'R1', 0, 1],

            // Переход через 0 без окончания на нём.
            [95, 'R60', 55, 1],
            [14, 'L82', 32, 1],
            [82, 'L30', 52, 0],
            [11, 'R8', 19, 0],

            // Один полный оборот всегда попадает на 0 один раз.
            [0, 'R100', 0, 1],
            [0, 'L100', 0, 1],
            [37, 'R100', 37, 1],
            [37, 'L100', 37, 1],

            // Несколько полных оборотов.
            [50, 'R1000', 50, 10],
            [50, 'L1000', 50, 10],
            [0, 'R201', 1, 2],
            [0, 'L201', 99, 2],

            // Несколько попаданий на 0, конечная позиция не равна 0.
            [20, 'R201', 21, 2],
            [20, 'L201', 19, 2],
            [1, 'L200', 1, 2],

            // Несколько попаданий, последнее совпадает с концом вращения.
            [37, 'R263', 0, 3],
            [37, 'L437', 0, 5],
            [1, 'R199', 0, 2],

            // Расстояние чуть больше полного оборота.
            [0, 'R101', 1, 1],
            [0, 'L101', 99, 1],
        ];
    }

    #[DataProvider('rotationData')]
    public function testDialRotate(int $position, string $rotation, int $expected): void
    {
        $solution = new Solver();

        $solution->setDail($position);
        $result = $solution->rotate($rotation);
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

        $solution->setDail($position);
        [
            'position' => $result,
            'fullRotationCount' => $count
        ] = $solution->rotateWithZeroCount($rotation);

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

    public function testGetRealCode(): void
    {
        $basePath = dirname(__DIR__, 3) . '/__examples';
        $input = new Input($basePath);

        $rotations = $input->forDay(1);
        $solution = new Solver();

        $result = $solution->getRealCode($rotations);
        self::assertSame(6, $result);
    }
}
