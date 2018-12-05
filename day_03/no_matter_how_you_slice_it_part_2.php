<?php

$file = fopen(__DIR__ . '/input', 'r');

$sheet = [];

$ids = [];

while ($measurementString = fgets($file)) {
    $matches = [];
    preg_match('/#(\d+) @ (\d+),(\d+): (\d+)x(\d+)/', $measurementString, $matches);

    list($measurementString, $id, $startX, $startY, $width, $height) = $matches;

    for ($i = $startX; $i <= $startX + $width - 1; $i++) {
        for ($j = $startY; $j <= $startY + $height - 1; $j++) {
            $sheet[$i][$j][] = $id;
            $ids[$id] = $id;
        }
    }
}

foreach($sheet as $row) {
    foreach($row as $square) {
        if(count($square) === 1) {
            continue;
        }
        
        $ids = array_diff($ids, $square);
    }
}

echo reset($ids) . PHP_EOL;