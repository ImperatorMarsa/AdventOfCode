<?php

declare(strict_types=1);

namespace AoC\Day01;

use Exception;

final class Solver
{
    private const MAX_POSITION = 100;
    private const MIN_POSITION = 0;

    private const LEFT_DIRECTION = 'L';
    private const RIGHT_DIRECTION = 'R';
    private const ALLOW_DIRECTIONS = [
        self::LEFT_DIRECTION,
        self::RIGHT_DIRECTION,
    ];

    public function rotate(int $position, string $rotation): int
    {
        $direction = $this->getDirection($rotation);
        $steps = $this->getSteps($rotation);

        $newPosition = $position + $direction * $steps;
        if ($newPosition == self::MAX_POSITION) {
            return 0;
        }
        if ($newPosition > self::MAX_POSITION) {
            return self::MAX_POSITION - ($newPosition - self::MAX_POSITION);
        }
        if ($newPosition < self::MIN_POSITION) {
            return self::MAX_POSITION - abs($newPosition);
        }

        return $newPosition;
    }

    private function getDirection(string $rotation): int
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
        if ($steps < self::MIN_POSITION) {
            throw new Exception("Колличество шагов вне диапазона: {$steps}.");
        }
        $fullRotationCount = (int) round(
            $steps / self::MAX_POSITION,
            0,
            PHP_ROUND_HALF_DOWN
        );

        return $steps - $fullRotationCount * self::MAX_POSITION;
    }
}
