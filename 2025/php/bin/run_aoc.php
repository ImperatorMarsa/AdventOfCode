<?php

use AoC\common\Input;

require dirname(__DIR__) . '/vendor/autoload.php';


$options = ['options' => [
    'min_range' => 1,
    'max_range' => 25,
]];
$day = filter_var($argv[1] ?? null, FILTER_VALIDATE_INT, $options);
if ($day === false) {
    fwrite(STDERR, "Использование: php bin/run_aoc.php <день 1-25> [часть 1|2]\n");
    exit(1);
}

$options = ['options' => [
    'min_range' => 1,
    'max_range' => 2,
]];
$part = filter_var($argv[2] ?? null, FILTER_VALIDATE_INT, $options);
if (isset($argv[2]) && $part === false) {
    fwrite(STDERR, "Номер части должен быть 1 или 2.\n");
    exit(1);
}

$calssName = sprintf('AoC\\Day%02d\\Solver', $day);
if (!class_exists($calssName)) {
    fwrite(STDERR, sprintf("Решение для дня %02d не найдено.\n", $day));
    exit(1);
}

$solution = new $calssName();
$basePath = dirname(__DIR__, 2) . '/__inputs';
$input = new Input($basePath);
$contents = $input->forDay($day);

if ($part === 1) {
    echo $solution->solvePartOne($contents), PHP_EOL;
    exit(0);
}
if ($part === 2) {
    echo $solution->solvePartTwo($contents), PHP_EOL;
    exit(0);
}

echo 'Part 1: ', $solution->solvePartOne($contents), PHP_EOL;
echo 'Part 2: ', $solution->solvePartTwo($contents), PHP_EOL;
