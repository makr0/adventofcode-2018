<?php

namespace Aoc2018\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day09Command extends DailyBase
{
    protected $AocName = 'aoc2018:day09';
    protected $AocDescription = "Day 9: Marble Mania";

    protected function parseInput($input) {
        preg_match('/([0-9]+) .* ([0-9]+)/', $input[0], $matches);
        return ['players' => (int)$matches[1], 'lastMarble' => (int)$matches[2]];
    }

    protected function part2($input) {
        $input['lastMarble'] *= 100;
        return $this->part1($input);
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        if(!extension_loaded ( 'ds')) {
            $output->writeln('This will be very slow without the php-ds extension!');
            $output->writeln('possible solution: apt install -y php-ds');
            $output->writeln('See: http://php.net/manual/en/ds.installation.php');
        }

        parent::execute($input, $output);
    }

    protected function part1($input) {
        $players = array_fill(0, $input['players'], 0);
        $ring = new \Ds\Deque();
        $marble = 0;
        $ring->push($marble);

        while (1) {
            for ($p = 0; $p < $input['players']; $p++) {
                if ($marble++ > $input['lastMarble']) {
                    break 2;
                }
                if ($marble % 23 == 0) {
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