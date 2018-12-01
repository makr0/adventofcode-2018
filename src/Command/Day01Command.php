<?php
namespace Aoc2018\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day01Command extends Command
{
    protected static $defaultName = 'aoc2018:day01';

    protected function configure()
    {
        $this
        ->setDescription('Day 1: Chronal Calibration');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $lines = file('php://stdin');

        $result1 = $this->part1($lines);
        $result2 = $this->part2($lines);

        $output->writeln("resulting Frequency (part1):$result1");
        $output->writeln("first Frequency seen twice (part2):$result2");
    }

    private function part1($lines) {
        $freq = 0;
        foreach($lines as $line) {
            $freq += (int)$line;
        }
        return $freq;
    }
    private function part2($lines) {
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