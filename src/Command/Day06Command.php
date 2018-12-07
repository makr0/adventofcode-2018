<?php

namespace Aoc2018\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day06Command extends Command
{
    protected static $defaultName = 'aoc2018:day06';
    /** @var OutputInterface */
    private $output;

    private $grid_start=[-500,-500];
    private $grid_end=[500,500];

    protected function configure() {
        $this
            ->setDescription('Day 6: Chronal Coordinates');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->output = $output;
        $this->output->writeln($this->getDescription());
        $lines = array_map('trim', file('php://stdin'));
        $pois = array_map(function($line){return explode(', ', $line);},$lines);

        $result1 = $this->part1($pois);
        $output->writeln("Size of the largest area (part1): $result1"); // toohigh: 6228, 5712, accepted: 4016
    }

    private function part1($pois) {
        $world=[];
        for($x=$this->grid_start[0]; $x<$this->grid_end[0]; $x++) {
            $world[$x]=[];
            for($y=$this->grid_start[1]; $y<$this->grid_end[1]; $y++) {
                $world[$x][$y] = $this->nearestPOI($x,$y,$pois);
            }
        }
        $sizes=[];
        for($x=$this->grid_start[0]; $x<$this->grid_end[0]; $x++) {
            for($y=$this->grid_start[1]; $y<$this->grid_end[1]; $y++) {
                $nearestIndex = $world[$x][$y];
                if($nearestIndex != -1) {
                    if(!isset($sizes[$nearestIndex])) $sizes[$nearestIndex] = 0;
                    $sizes[$nearestIndex]++;
                }
            }
        }
        sort($sizes);
        dump($sizes);
        return 0;
    }

    private function nearestPOI(int $x, int $y, $pois) {
        $nearest = null;
        $distances = [];
        foreach ($pois as $index => $coordinates) {
            $distances[$index] = $this->manhattanDistance($x, $y, $coordinates[0], $coordinates[1]);
        }
        $minDistance = min($distances);
        $distanceHistogram = array_count_values($distances);
        $distanceToIndex = array_flip($distances);
        return $distanceHistogram[$minDistance] == 1 ? $distanceToIndex[$minDistance] : -1;
    }

    private function manhattanDistance(int $x1, int $y1, int $x2, int $y2) {
        return abs($x1-$x2) + abs($y1-$y2);
    }


}