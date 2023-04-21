<?php

namespace App\Profiler;
require_once $_SERVER['DOCUMENT_ROOT'] . "/function/function.php";

use App\Timer\Timer;
use IProfiler;

class Profiler implements IProfiler
{
    private array $timers = array();

    public function __construct()
    {
        
    }

    public function startTimer(string $timerName)
    {

        if (!isset($this->timers[$timerName])) {
            $this->timers[$timerName] = array(
                'timerName' => $timerName,
                'count' => 0,
                'duration' => 0,
            );
        }

        $this->timers[$timerName]['startTime'] = microtime(1);
        $this->timers[$timerName]['count']++;
    }

    public function endTimer(string $timerName)
    {
        $this->timers[$timerName]['duration'] += microtime(1) - $this->timers[$timerName]['startTime'];
    }

    public function getTimers(): array
    {
        $result = array();

        foreach ($this->timers as $key => $timer) {
            if ($key == 'main') {
                $result[$key]['duration'] = round($timer['duration'] - $this->timers['doLoop']['duration'], 3);
            } else if ($key == 'doLoop') {
                $result[$key]['duration'] = round($timer['duration'] - $this->timers['processItem']['duration'], 3);
            } else {
                $result[$key]['duration'] = round($timer['duration'], 3);
            }

            $result[$key]['count'] = $timer['count'];
        }

        return $result;
    }

}