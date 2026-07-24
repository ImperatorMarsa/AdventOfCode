<?php

declare(strict_types=1);

namespace Tests\Day02;

use AoC\Day02\Solver;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class SolverTest extends TestCase
{
    public static function repeatedPatterns(): array
    {
        return [
            [55, true],
            [222, false],
            [6464, true],
            [222223, false],
            [123123, true],
            [0101, false],
        ];
    }

    #[DataProvider('repeatedPatterns')]
    public function testRepeatedPatterns(int $pattern, bool $expected): void
    {
        $solution = new Solver();

        $result = $solution->isRepeatedPattern($pattern);
        self::assertSame($expected, !is_null($result));
    }

    public static function idRange(): array
    {
        return [
            ['11-22', [11, 22]],
            ['95-115', [99]],
            ['998-1012', [1010]],
            ['1698522-1698528', []],
        ];
    }

    #[DataProvider('idRange')]
    public function testIdRange(string $idRange, array $expected): void
    {
        $solution = new Solver();

        $result = $solution->getRepeatedPatterns($idRange);
        self::assertSame($expected, $result);
    }
}
