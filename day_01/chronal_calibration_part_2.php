<?php

$file = fopen(__DIR__ . '/input', 'r');

$frequencies = [0];

while (true) {
    while ($adjustment = fgets($file)) {
        @$newFrequency = end($frequencies) + $adjustment;

        if (in_array($newFrequency, $frequencies)) {
            echo $newFrequency;
            die;
        }

        $frequencies[] = $newFrequency;
    }
    rewind($file);
}
