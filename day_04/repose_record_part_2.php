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
        $rollingGuardString = null;
        $rollingMinute = null;
        $rollingHighestSleepTally = 0;
        
        foreach($this->timeTally as $guardString => $minutes) {
            foreach($minutes as $minute => $sleepTally) {
                if($sleepTally > $rollingHighestSleepTally) {
                    $rollingGuardString = $guardString;
                    $rollingMinute = $minute;
                    $rollingHighestSleepTally = $sleepTally;
                }
            }
        }
        
        return $this->extractGuardId($rollingGuardString) * $rollingMinute;
    }
    
    private function extractGuardId(string $guardString): int
    {
        $matches = [];
        preg_match('#\d+#', $guardString, $matches);

        return $matches[0];
    }
}

$fileContents = file_get_contents(__DIR__ . '/input');

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