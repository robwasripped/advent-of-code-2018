<?php

$coordinates = [];

$file = fopen(__DIR__ . '/input', 'r');

$smallestX = PHP_INT_MAX;
$smallestY = PHP_INT_MAX;
$largestX = 0;
$largestY = 0;

while ($coordinateString = fgets($file)) {
    $point = array_map('intval', explode(', ', $coordinateString));

    $smallestX = min([$smallestX, $point[0]]);
    $smallestY = min([$smallestY, $point[1]]);
    $largestX = max([$largestX, $point[0]]);
    $largestY = max([$largestY, $point[1]]);

    $coordinates[] = $point;
}

$pointCount = 0;

for ($i = $smallestX; $i <= $largestX; $i++) {

    for ($j = $smallestY; $j <= $largestY; $j++) {
        
        $pointDistanceSum = 0;

        foreach ($coordinates as $id => $point) {
            $pointDistanceSum += abs($i - $point[0]) + abs($j - $point[1]);
        }

        if($pointDistanceSum < 10000) {
            $pointCount++;
        }
    }
}

echo $pointCount . PHP_EOL;
