<?php

$polymer = file_get_contents(__DIR__ . '/input');

while(true) {
    $result = preg_replace('#(.)(?=(?i:\1))(?!\1)(?i:\1)#', '', $polymer);
    
    if($result === $polymer) {
        break;
    }
    
    $polymer = $result;
}

echo strlen($polymer) . PHP_EOL;