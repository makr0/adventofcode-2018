<?php

namespace Aoc2018\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day04Command extends DailyBase
{
    protected $AocName = 'aoc2018:day04';
    protected $AocDescription = "Day 4: Repose Record";

    protected function parseInput($input)
    {
        return $this->makeTimeTable($input);
    }

    protected function part1($timetable) {
        $sleepiest_guard = $sleepiest_minute = $maxSleep = 0;
        foreach($timetable as $id => $minutes) {
            $minutes_asleep = array_sum($minutes);
            if($maxSleep<$minutes_asleep) {
                $maxSleep=$minutes_asleep;
                $sleepiest_guard = $id;
                $sleepiest_minute = (array_search(max($minutes),$minutes));
            }
        }
        return $sleepiest_guard * $sleepiest_minute;
    }


    protected function part2($timetable) {
        $maxGuard=['id'=>0,'sleepMinutes'=>0,'minute'=>0];
        foreach($timetable as $id => $minutes) {
            foreach($minutes as $minute => $timesAsleepOnThatMinute) {
                if($maxGuard['sleepMinutes'] < $timesAsleepOnThatMinute) {
                    $maxGuard=['id'=>$id,'sleepMinutes'=>$timesAsleepOnThatMinute,'minute'=>$minute];
                }
            }
        }
        return $maxGuard['id'] * $maxGuard['minute'];
   }

   private function makeTimeTable($lines) {
    asort($lines);
    $timetable = [];
    foreach($lines as $line) {
        preg_match ( '~^\[(.*) \d+:(\d+)\] (.*)$~', $line, $lineparts );
        $minute = $lineparts[2];
        $event = $lineparts[3];
        if(preg_match ( '~^Guard #(\d+) begins shift$~', $event, $matches )) {
            $guard = $matches[1];
            if(!isset($timetable[$guard])) $timetable[$guard] = [];
        }
        if(preg_match ( '~^falls asleep$~', $event, $matches )) {
            $asleep = (int)$lineparts[2];
        }
        if(preg_match ( '~^wakes up$~', $event, $matches )) {
            $awoke = (int)$lineparts[2];
            for($i=$asleep; $i<$awoke; $i++) {
                if(!isset($timetable[$guard][$i])) $timetable[$guard][$i] = 0;
                $timetable[$guard][$i]++;
            }
        }
    }
    return $timetable;
}

}