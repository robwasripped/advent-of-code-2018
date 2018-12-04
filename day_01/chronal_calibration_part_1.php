<?php

$file = fopen(__DIR__ . '/input', 'r');

$frequency = 0;

while($adjustment = fgets($file)) {
    $frequency += $adjustment;
}

echo $frequency . PHP_EOL;
