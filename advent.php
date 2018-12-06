<?php

$optind = null;

$opts = getopt('i:', [], $optind);

$script = $argv[$optind] ?? null;

if(!$script) {
    die('Please enter a script to execute.' . PHP_EOL);
}

if(!file_exists($script)) {
    die(sprintf('File "%s" not found.', $script) . PHP_EOL);
}

$inputFilename = $opts['i'] ?? dirname($script) . '/input';

if(!file_exists($inputFilename)) {
    die(sprintf('Input file "%s" not found.', $inputFilename) . PHP_EOL);
}

include($script);