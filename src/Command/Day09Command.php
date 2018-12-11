<?php
namespace Aoc2018\Command;

class Day09Command extends DailyBase
{
    protected $AocName = 'aoc2018:day09';
    protected $AocDescription = "Day 9: Marble Mania";

    protected function parseInput($input) {
        preg_match('/([0-9]+) .* ([0-9]+)/',$input[0],$matches);
        return ['players'=>(int)$matches[1], 'points'=>(int)$matches[2]];
    }

    protected function part2($input) {
        $input['points'] *= 100;
        return $this->part1($input);
    }

    protected function part1($input) {
        $this->output->writeln('This will be very slow without the php-ds extension!');
        $players = array_fill(0,$input['players'],0);
        $ring = new \Ds\Deque();
        $marble=0;
        $ring->push($marble);
        while(1) {
            for($p=0;$p<$input['players'];$p++) {
                if($marble++ > $input['points']) break 2;
                if($marble%23 == 0) {
                    $players[$p] += $marble;
                    $ring->rotate(-7);
                    $players[$p] += $ring->pop();
                    $ring->rotate(1);
                } else {
                    $ring->rotate(1);
                    $ring->push($marble);
                }
            }
        }
        return max($players);
    }


}