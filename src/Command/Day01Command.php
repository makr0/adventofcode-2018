<?php
namespace Aoc2018\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day01Command extends DailyBase
{
    protected $AocName = 'aoc2018:day01';
    protected $AocDescription = "Day 1: Chronal Calibration";


    protected function part1($lines) {
        $freq = 0;
        foreach($lines as $line) {
            $freq += (int)$line;
        }
        return $freq;
    }
    protected function part2($lines) {
        $freq = 0;
        $seenFreqs = [];
        while(1) {
            foreach($lines as $line) {
                $freq += (int)$line;
                if( !isset($seenFreqs[$freq])) {
                    $seenFreqs[$freq]=1;
                } else {
                    return $freq;
                }
            }
        }
    }
}