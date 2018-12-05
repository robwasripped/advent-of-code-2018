<?php

$file = fopen(__DIR__ . '/input', 'r');

$twoLetterCount = 0;
$threeLetterCount = 0;

while($id = fgets($file)) {
    $characterCount = count_chars($id, 1);
    
    if(in_array(2, $characterCount)) {
        $twoLetterCount++;
    }
    
    if(in_array(3, $characterCount)) {
        $threeLetterCount++;
    }
}

echo $twoLetterCount * $threeLetterCount;
