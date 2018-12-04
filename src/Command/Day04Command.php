<?php

namespace Aoc2018\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day04Command extends Command
{
    protected static $defaultName = 'aoc2018:day04';
    /** @var OutputInterface */
    private $output;

    protected function configure() {
        $this
            ->setDescription('Day 4: Repose Record');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->output = $output;
        $lines = array_map('trim', file('php://stdin'));
        asort($lines);
//        dump($lines);

        $result1 = $this->part1($lines);
//        $result2 = $this->part2($claims, $fabric);

        $output->writeln("Minutes asleep the most (part1): $result1"); // accepted:
//        $output->writeln("first untaitned claim (part2): $result2"); // accepted:
    }

    private function part1($lines) {
        $guards = [];
        foreach($lines as $line) {
            preg_match ( '~^\[(.*) \d+:(\d+)\] (.*)$~', $line, $lineparts );
            if(preg_match ( '~^Guard #(\d+) begins shift$~', $lineparts[3], $matches )) {
                $guard = $matches[1] ;
            }
            if(preg_match ( '~^falls asleep$~', $lineparts[3], $matches )) {
                $time_asleep = (int)$lineparts[2];
            }
            if(preg_match ( '~^wakes up$~', $lineparts[3], $matches )) {
                $awake = (int)$lineparts[2];
                for($i=$time_asleep; $i<$awake; $i++) {
                    if(!isset($guards[$guard][$i])) $guards[$guard][$i] = 0;
                    $guards[$guard][$i]++;
                }
            }
        }
        $maxguard=[0,0];
        foreach($guards as $id => $minutes) {
            foreach($minutes as $minute => $sleeptime) {
                if($maxguard[0]<$sleeptime) {
                    $maxguard=[$minute,$id];
                }
            }
        }
        dump($maxguard);
        return $maxguard[0] * $maxguard[1];
    }

    private function part2($claims,$fabric) {
        return '--ERROR--';
    }
}