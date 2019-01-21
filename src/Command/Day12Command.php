<?php
namespace Aoc2018\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day12Command extends DailyBase
{
    protected $AocName = 'aoc2018:day12';
    protected $AocDescription = "Day 12: Subterranean Sustainability";
    private   $rules = [];


    protected function parseInput($input) {
        $input = array_map('trim',$input);
        $initialString = array_shift($input);
        $initialString = preg_replace('/[^#.]/','',$initialString); // #..####.##..#.##.#..#..  
        $initialState = [];
        foreach (str_split($initialString) as $position => $pot) {
            if($pot == '#') $initialState[]=$position;
        }

        $this->rules = [];
        foreach ($input as $line) {
            if(!empty($line)) {
                list($pattern,$result) = explode(' => ',$line);
                $this->rules[$pattern] = $result;
            }
        }
        return $initialState;
    }


    protected function part1($state) {
        foreach(range(1,20) as $k) {
            $state = $this->step($state);
        }
        return array_sum($state);
    }
    protected function part2($state) {
        $period = 0;
        $sum = 0;
        $diff = 0; $lastdiff = 1;
        while($diff != $lastdiff) {
            $lastdiff = $diff;
            $nextState = $this->step($state);
            $diff = array_sum($nextState) - array_sum($state);
            $period++;
            $state = $nextState;
        }
        $result =  $diff * (50000000000 - $period) + array_sum($state);
        return $result . " (Period $period)";
    }
    

    private function step($state) {
        $nextState = [];
        foreach (range(min($state)-2,max($state)+2) as $pot) {
            $pattern = '';
            foreach (range($pot-2,$pot+2) as $testPot) {
                $pattern .= in_array($testPot,$state) ? '#':'.';
            }
            if(isset($this->rules[$pattern]) && $this->rules[$pattern] == '#') {
                $nextState[]=$pot;
            }
        }
        return $nextState;
    }

}