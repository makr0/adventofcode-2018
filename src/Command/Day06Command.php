<?php

namespace Aoc2018\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day06Command extends DailyBase
{
    protected $AocName = 'aoc2018:day06';
    protected $AocDescription = "Day 6: Chronal Coordinates";

    private $grid_start=[0,0];
    private $grid_end=[400,400];

    protected function parseInput($lines)
    {
        return  array_map(function($line){return explode(', ', trim($line));},$lines);
    }

    protected function part1($pois) {
        $world=[];
        $grid_start = -500;
        $grid_size = 1000;
        for($x=$grid_start; $x<$grid_start+$grid_size; $x++) {
            $world[$x]=[];
            for($y=$grid_start; $y<$grid_start+$grid_size; $y++) {
                $world[$x][$y] = $this->nearestPOI($x,$y,$pois);
            }
        }
        $sizes=[];
        for($x=$grid_start; $x<$grid_start+$grid_size; $x++) {
            for($y=$grid_start; $y<$grid_start+$grid_size; $y++) {
                $nearestIndex = $world[$x][$y];
                if($nearestIndex != -1) {
                    if(!isset($sizes[$nearestIndex])) $sizes[$nearestIndex] = 0;
                    $sizes[$nearestIndex]++;
                }
            }
        }
        sort($sizes);
        $sizes = array_filter($sizes,function($s){ return $s<5000;});
        return array_pop($sizes);
    }
    protected function part2($pois) {
        $area = 0;
        for($x=$this->grid_start[0]; $x<$this->grid_end[0]; $x++) {
            for($y=$this->grid_start[1]; $y<$this->grid_end[1]; $y++) {
                if($this->distanceSum($x,$y,$pois) < 10000) $area++;
            }
        }
        return $area;
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
    private function distanceSum(int $x, int $y, $pois) {
        $sum = 0;
        foreach ($pois as $index => $coordinates) {
            $sum += $this->manhattanDistance($x, $y, $coordinates[0], $coordinates[1]);
        }
        return $sum;
    }

    private function manhattanDistance(int $x1, int $y1, int $x2, int $y2) {
        return abs($x1-$x2) + abs($y1-$y2);
    }


}