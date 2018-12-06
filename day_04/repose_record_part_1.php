<?php

class TimeTracker {
    private $timeTally = [];
    
    private $guardOnDuty;
    
    private $sleepStartMinute;
    
    public function startShift(string $guardString): void
    {
        $this->guardOnDuty = $guardString;
    }
    
    public function beginSleep(int $sleepStartMinute): void
    {
        $this->sleepStartMinute = $sleepStartMinute;
    }
    
    public function wakeUp(int $sleepEndMinute): void
    {
        for($i = $this->sleepStartMinute; $i % 60 < $sleepEndMinute; $i++) {
            if(!isset($this->timeTally[$this->guardOnDuty][$i])) {
                $this->timeTally[$this->guardOnDuty][$i] = 1;
            } else {
                $this->timeTally[$this->guardOnDuty][$i]++;
            }
        }
    }
    
    public function getSolutionChecksum(): int
    {
        $guardString = $this->getSleepiestGuard();
        $sleepiestMinute = $this->getSleepiestMinute($guardString);
        
        $guardId = $this->extractGuardId($guardString);
        
        return $guardId * $sleepiestMinute;
    }
    
    private function getSleepiestGuard(): string
    {
        $sleepSums = array_map('array_sum', $this->timeTally);
        
        arsort($sleepSums);
        
        return key($sleepSums);
    }
    
    private function getSleepiestMinute(string $guardString): int
    {
        arsort($this->timeTally[$guardString]);
        
        return key($this->timeTally[$guardString]);
    }
    
    private function extractGuardId(string $guardString): int
    {
        $matches = [];
        preg_match('#\d+#', $guardString, $matches);

        return $matches[0];
    }
}

$fileContents = file_get_contents($inputFilename);

$records = explode("\n", $fileContents);

sort($records);
unset($records[0]);

$timeTracker = new TimeTracker();

foreach($records as $record) {
    $matches = [];
    preg_match('#\[\d+\-\d+-\d+ \d+:(\d+)] (.+)#', $record, $matches);

    switch (substr($matches[2], 0, 5)) {
        case 'Guard':
            $timeTracker->startShift($matches[2]);
            break;
        case 'falls':
            $timeTracker->beginSleep($matches[1]);
            break;
        case 'wakes':
            $timeTracker->wakeUp($matches[1]);
            break;
    }
}

echo $timeTracker->getSolutionChecksum() . PHP_EOL;