<?php

declare(strict_types=1);

namespace AoC\Day02;

use AoC\common\Solution;
use Exception;
use Override;

final class Solver implements Solution
{
    private const RANGE_SEPARATOR = ',';
    private const ID_SEPARATOR = '-';

    #[Override]
    public function solvePartOne(string $input): int
    {
        throw new Exception('Not implemented');
    }

    #[Override]
    public function solvePartTwo(string $input): int
    {
        throw new Exception('Not implemented');
    }

    public function isRepeatedPattern(int $id): ?int
    {
        $sId = ltrim(trim(strval($id)), '0');
        $idLen = strlen($sId);
        if ($idLen % 2) {
            return null;
        }

        $leftHalf = substr($sId, 0, $idLen / 2);
        $rightHalf = substr($sId, $idLen / 2);
        if ($leftHalf == $rightHalf) {
            return $id;
        }

        return null;
    }
}
