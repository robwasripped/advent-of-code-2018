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

$infiniteBlacklist = [];
$pointCount = [];

for ($i = $smallestX; $i <= $largestX; $i++) {

    for ($j = $smallestY; $j <= $largestY; $j++) {

        $pointDistances = [];
        foreach ($coordinates as $id => $point) {
            $pointDistances[$id] = abs($i - $point[0]) + abs($j - $point[1]);
        }

        asort($pointDistances);

        $closestPointKey = key($pointDistances);

        if (($i === $smallestX || $i === $largestX || $j === $smallestY || $j === $largestY) && !in_array($closestPointKey, $pointDistances)) {
            $infiniteBlacklist[] = $closestPointKey;
        }

        if (current($pointDistances) !== next($pointDistances)) {
            @$pointCount[$closestPointKey] ++;
        }
    }
}

$nonInfinitePointCount = array_filter($pointCount, function($pointKey) use ($infiniteBlacklist) {
    return !in_array($pointKey, $infiniteBlacklist);
}, ARRAY_FILTER_USE_KEY);

arsort($nonInfinitePointCount);

echo reset($nonInfinitePointCount) . PHP_EOL;
