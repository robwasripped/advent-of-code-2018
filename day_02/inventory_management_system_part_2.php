<?php

$file = fopen(__DIR__ . '/input', 'r');

$explodedIds = [];

while($id = fgets($file)) {
    $explodedId = str_split($id);
    
    foreach($explodedIds as $existingExplodedId) {
        if(count($differentCharacters = array_diff_assoc($explodedId, $existingExplodedId)) === 1) {
            
            unset($explodedId[key($differentCharacters)]);
            echo implode('', $explodedId) . PHP_EOL;
        }
    }
    
    $explodedIds[] = $explodedId;
}