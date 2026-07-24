<?php

declare(strict_types=1);

namespace AoC\Day02;

use AoC\common\Solution;
use Exception;
use Override;

final class Solver implements Solution
{
    private const RANGE_STEP = 1;

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

    /**
     * @param string $idRange
     *
     * @return array<int>
     */
    public function getRepeatedPatterns(string $idRange): array
    {
        $repeatedPatternsId = [];
        $idRange = $this->checkRange($idRange);

        foreach (range($idRange[0], $idRange[1], self::RANGE_STEP) as $id) {
            $repatedId = $this->isRepeatedPattern($id);
            if (isset($repatedId)) {
                $repeatedPatternsId[] = $repatedId;
            }
        }

        return $repeatedPatternsId;
    }

    /**
     * @param string $idRange
     *
     * @return array<int, int>
     *
     * @throws Exception
     */
    private function checkRange(string $idRange): array
    {
        $separatorPosition = strpos($idRange, self::ID_SEPARATOR);
        if (
            substr_count($idRange, self::ID_SEPARATOR) != 1 or
            $separatorPosition == 0 or
            $separatorPosition == strlen($idRange)
        ) {
            throw new Exception("'{$idRange}' не соответствует формату 'диапазону ID'");
        }

        $newIdRange = [];
        $edges = explode(self::ID_SEPARATOR, $idRange);
        foreach ($edges as $edge) {
            $filteredEdge = filter_var($edge, FILTER_VALIDATE_INT);
            if ($filteredEdge === false) {
                throw new Exception("Граница диапазона ID не является целым числом: {$filteredEdge}.");
            }
            $newIdRange[] = intval($filteredEdge);
        }

        return $newIdRange;
    }
}
