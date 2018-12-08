<?php

$polymer = file_get_contents(__DIR__ . '/input');

$shortestPolymerLength = strlen($polymer);

foreach(range('a','z') as $removedUnit) {
    $alteredPolymer = str_ireplace($removedUnit, '', $polymer);
    
    while(true) {
        $result = preg_replace('#(.)(?=(?i:\1))(?!\1)(?i:\1)#', '', $alteredPolymer);

        if($result === $alteredPolymer) {
            break;
        }

        $alteredPolymer = $result;
    }
    
    $shortestPolymerLength = min([$shortestPolymerLength, strlen($alteredPolymer)]);
}

echo $shortestPolymerLength . PHP_EOL;