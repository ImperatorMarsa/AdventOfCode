<?php

declare(strict_types=1);

namespace AoC\Day01;

use Exception;

final class Solver
{
    private const LEFT_DIRECTION = 'L';
    private const RIGHT_DIRECTION = 'R';
    private const ALLOW_DIRECTIONS = [
        self::LEFT_DIRECTION,
        self::RIGHT_DIRECTION,
    ];

    public function rotate(int $position, string $rotation): int
    {
        $direction = $this->getDerection($rotation);
        $steps = $this->getSteps($rotation);

        return $position + $direction * $steps;
    }

    private function getDerection(string $rotation): int
    {
        $direction = strtoupper(substr($rotation, 0, 1));
        if (!in_array($direction, self::ALLOW_DIRECTIONS)) {
            throw new Exception("Неопределённый тип направления: {$direction}.");
        }

        return $direction == self::LEFT_DIRECTION ? -1 : 1;
    }

    private function getSteps(string $rotation): int
    {
        $steps = substr($rotation, 1);
        if (!is_numeric($steps)) {
            throw new Exception("Колличество шагов не является целым числом: {$steps}.");
        }
        $steps = (int)$steps;
        if ($steps > 99 || $steps < 0) {
            throw new Exception("Колличество шагов вне диапазона: {$steps}.");
        }

        return $steps;
    }
}
