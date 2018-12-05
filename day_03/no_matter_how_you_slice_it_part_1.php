<?php

$file = fopen(__DIR__ . '/input', 'r');

$sheet = [];

$collisions = 0;

while ($measurementString = fgets($file)) {
    $matches = [];
    preg_match('/#(\d+) @ (\d+),(\d+): (\d+)x(\d+)/', $measurementString, $matches);

    list($measurementString, $id, $startX, $startY, $width, $height) = $matches;

    for ($i = $startX; $i <= $startX + $width - 1; $i++) {
        for ($j = $startY; $j <= $startY + $height - 1; $j++) {
            if (!isset($sheet[$i][$j])) {
                $sheet[$i][$j] = 1;
                continue;
            }

            if (++$sheet[$i][$j] === 2) {
                $collisions++;
            }
        }
    }
}

echo $collisions . PHP_EOL;
