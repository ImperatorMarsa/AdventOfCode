<?php

declare(strict_types=1);

namespace AoC\Day01;

use Exception;

final class Solver
{
    private const MIN_POSITION = 0;
    private const MAX_POSITION = 99;
    private const MAX_POSITION_OVERFLOW = self::MAX_POSITION + 1;

    private const LEFT_DIRECTION = 'L';
    private const RIGHT_DIRECTION = 'R';
    private const ALLOW_DIRECTIONS = [
        self::LEFT_DIRECTION,
        self::RIGHT_DIRECTION,
    ];

    public function rotate(int $position, string $rotation): int
    {
        ['position' => $newPosition, 'fullRotationCount' => $_] = $this->rotateWithZeroCount($position, $rotation);

        return $newPosition;
    }

    /**
     * @return array{
     *     position: int,
     *     fullRotationCount: int
     * }
     */
    public function rotateWithZeroCount(int $position, string $rotation): array
    {
        $direction = $this->getDirection($rotation);
        $steps = $this->getSteps($rotation);

        $newPosition = $position + $direction * $steps;
        if ($newPosition > self::MAX_POSITION) {
            $newPosition = $newPosition - self::MAX_POSITION_OVERFLOW;
        } else if ($newPosition < self::MIN_POSITION) {
            $newPosition = self::MAX_POSITION_OVERFLOW + $newPosition;
        }

        return ['position' => $newPosition, 'fullRotationCount' => 0];
    }

    public function getCode(string $rotations): int
    {
        $rotations = preg_split("/\r\n|\n|\r/", $rotations);

        $position = 50;
        $zeroCounter = 0;
        foreach ($rotations as $rotation) {
            if (empty($rotation)) {
                continue;
            }

            $position = $this->rotate($position, $rotation);
            if ($position == 0) {
                $zeroCounter++;
            }
        }
        return $zeroCounter;
    }

    public function getRealCode(string $rotations): int
    {
        return 0;
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
            $steps / self::MAX_POSITION_OVERFLOW,
            0,
            PHP_ROUND_HALF_DOWN
        );

        return $steps - $fullRotationCount * self::MAX_POSITION_OVERFLOW;
    }
}
