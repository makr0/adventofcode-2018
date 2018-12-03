<?php

namespace Aoc2018\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day03Command extends Command
{
    protected static $defaultName = 'aoc2018:day03';
    /** @var OutputInterface */
    private $output;

    protected function configure() {
        $this
            ->setDescription('Day 3: No Matter How You Slice It');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->output = $output;
        $lines = array_map('trim', file('php://stdin'));

        $result1 = $this->part1($lines);
//        $result2 = $this->part2($lines);

        $output->writeln("area claimed more than once (part1): $result1");
//        $output->writeln("common chars (part2): $result2");
    }

    private function part1($lines) {
        $fabric = [];
        for($x=0;$x<1000;$x++) {
            for($y=0;$y<1000;$y++) {
                $fabric[$x][$y] = 0;
            }
        }
        $claims = [];
        foreach ($lines as $line) {
            $parts = explode(' ', $line);
            $start = explode(',', str_replace(':', '', $parts[2]));
            $claim = [
                'id' => $parts[0],
                'start' => [(int)$start[0],(int)$start[1]]
            ];
            $size = explode('x', $parts[3]);
            $claim['end'] = [
                $claim['start'][0] + $size[0],
                $claim['start'][1] + $size[1]
            ];
            $claims[]=$claim;
        }
        $multiClaimed=0;
        foreach ($claims as $claim) {
            for ($x = $claim['start'][0]; $x < $claim['end'][0]; $x++) {
                for ($y = $claim['start'][1]; $y < $claim['end'][1]; $y++) {
                    $fabric[$x][$y] = $fabric[$x][$y]+1;
                    if($fabric[$x][$y]>1) {
                        $multiClaimed++;
                    }
                }
            }

//            $this->output->writeln(vsprintf('%s: %d,%d:%d,%d => %d',[$claim['id'],$claim['start'][0],$claim['start'][1],$claim['end'][0],$claim['end'][1],$multiClaimed]));
        }
//        for($x=0;$x<1000;$x++) {
//            for($y=0;$y<1000;$y++) {
//                switch( $fabric[$x][$y]) {
//                    case 0: $this->output->write(' '); break;
//                    case 1: $this->output->write('.'); break;
//                    default: $this->output->write($fabric[$x][$y]); break;
//                }
//            }
//            $this->output->writeln('');
//        }

        return $multiClaimed;
    }

    private function part2($lines) {
    }
}