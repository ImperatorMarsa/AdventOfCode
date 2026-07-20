<?php

namespace AoC\common;

use Exception;

final readonly class Input
{
    public function __construct(
        private string $basePath
    ) {}

    public function forDay(int $day): string
    {
        if ($day < 1 or $day > 25) {
            throw new Exception("Номер дня должен быть от 1 до 25, передано: {$day}");
        }

        $filename = "{$this->basePath}/Day{$day}.txt";
        $input = file_get_contents($filename);
        if ($input === false) {
            throw new Exception("Не удалось прочитать входные данные: {$filename}");
        }

        return $input;
    }
}
