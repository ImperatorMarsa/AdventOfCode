<?php

declare(strict_types=1);

namespace AoC\Day01;

use AoC\common\Solution;
use Exception;

final class Solver implements Solution
{
    private const MIN_POSITION = 0;
    private const MAX_POSITION = 99;
    private const STEP = 1;

    private const LEFT_DIRECTION = 'L';
    private const RIGHT_DIRECTION = 'R';
    private const ALLOW_DIRECTIONS = [
        self::LEFT_DIRECTION,
        self::RIGHT_DIRECTION,
    ];

    /** @var array<int> */
    private array $dail = [];

    public function __construct()
    {
        $this->resetDial();
    }

    public function rotate(string $rotation): int
    {
        ['position' => $newPosition, 'fullRotationCount' => $_] = $this->rotateWithZeroCount($rotation);

        return $newPosition;
    }

    /**
     * @return array{
     *     position: int,
     *     fullRotationCount: int
     * }
     */
    public function rotateWithZeroCount(string $rotation): array
    {
        $direction = $this->getDirection($rotation);
        $steps = $this->getSteps($rotation);

        $fullRotationCount = 0;
        for ($i = 0; $i < $steps; $i++) {
            if ($direction == self::LEFT_DIRECTION) {
                $this->rotateDialToLeft();
            } else {
                $this->rotateDialToRight();
            }
            if ($this->getDialPosition() == self::MIN_POSITION) {
                $fullRotationCount++;
            }
        }

        return ['position' => $this->getDialPosition(), 'fullRotationCount' => $fullRotationCount];
    }

    public function solvePartOne(string $input): int
    {
        ['zeroPositionCounter' => $counter, 'zeroCounter' => $_] = $this->getPositionAndRotationZeroCount($input);
        return $counter;
    }

    public function solvePartTwo(string $input): int
    {
        ['zeroPositionCounter' => $_, 'zeroCounter' => $counter] = $this->getPositionAndRotationZeroCount($input);
        return $counter;
    }

    public function setDial(int $startPosition): void
    {
        if ($startPosition < self::MIN_POSITION or $startPosition > self::MAX_POSITION) {
            throw new Exception(sprintf(
                "Начальная позиция должна находиться в диапазоне между %02d и %02d\n",
                self::MIN_POSITION,
                self::MAX_POSITION
            ));
        }
        if ($startPosition == self::MIN_POSITION) {
            $this->resetDial();

            return;
        }

        $this->dail = [
            ...range($startPosition, self::MAX_POSITION, self::STEP),
            ...range(self::MIN_POSITION, $startPosition - self::STEP, self::STEP)
        ];
    }

    /**
     * @return array{
     *     zeroPositionCounter: int,
     *     zeroCounter: int
     * }
     */
    private function getPositionAndRotationZeroCount(string $rotations): array
    {
        $this->setDial(50);

        $rotations = preg_split("/\r\n|\n|\r/", $rotations);

        $zeroCounter = 0;
        $zeroPositionCounter = 0;
        foreach ($rotations as $rotation) {
            if (empty($rotation)) {
                continue;
            }

            ['position' => $position, 'fullRotationCount' => $count] = $this->rotateWithZeroCount($rotation);
            $zeroCounter += $count;
            if ($position == 0) {
                $zeroPositionCounter++;
            }
        }
        return [
            'zeroPositionCounter' => $zeroPositionCounter,
            'zeroCounter' => $zeroCounter
        ];
    }

    private function getDirection(string $rotation): string
    {
        $direction = strtoupper(substr($rotation, 0, 1));
        if (!in_array($direction, self::ALLOW_DIRECTIONS)) {
            throw new Exception("Неопределённый тип направления: {$direction}.");
        }

        return $direction;
    }

    private function getSteps(string $rotation): int
    {
        $steps = filter_var(substr($rotation, 1), FILTER_VALIDATE_INT);
        if ($steps === false) {
            throw new Exception("Колличество шагов не является целым числом: {$steps}.");
        }
        if ($steps < self::MIN_POSITION) {
            throw new Exception("Колличество шагов вне диапазона: {$steps}.");
        }

        return $steps;
    }

    private function resetDial(): void
    {
        $this->dail = range(self::MIN_POSITION, self::MAX_POSITION, self::STEP);
    }

    private function rotateDialToRight(): void
    {
        $elementToEnd = array_shift($this->dail);
        array_push($this->dail, $elementToEnd);
    }

    private function rotateDialToLeft(): void
    {
        $elementToStart = array_pop($this->dail);
        array_unshift($this->dail, $elementToStart);
    }

    public function getDialPosition(): int
    {
        return array_first($this->dail);
    }
}
