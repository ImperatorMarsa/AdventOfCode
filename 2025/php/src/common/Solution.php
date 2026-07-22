<?php

namespace AoC\common;

interface Solution
{
    public function solvePartOne(string $input): int;

    public function solvePartTwo(string $input): int;
}
