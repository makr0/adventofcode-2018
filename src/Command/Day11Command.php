<?php

namespace Aoc2018\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day11Command extends DailyBase
{
    protected $AocName = 'aoc2018:day11';
    protected $AocDescription = "Day 11: Chronal Charge";
    private $grid = [];
    private $gridSum = [];
    private $serial = 0;
    private $gridSize = 300;

    protected function parseInput($input)
    {
        $this->serial = (int)$input[0];
        $this->calculateGridPowerlevels();
        $this->summedAreaTable();
    }

    protected function part1($serial)
    {
        $maxSum = 0;
        $mx = $my = 0;
        $squareSize = 3;
        for ($y = 1; $y <= $this->gridSize - $squareSize; $y++) {
            for ($x = 1; $x <= $this->gridSize - $squareSize; $x++) {
                $sum = $this->gridSum($x, $y, $squareSize);
                if ($maxSum < $sum) {
                    $mx = $x;
                    $my = $y;
                    $maxSum = $sum;
                }

            }
        }
        return "$mx,$my";
    }

    protected function part2($serial)
    {
        $maxSum = 0;
        $mx = $my = $ms = 0;
        for ($y = 1; $y <= $this->gridSize; $y++) {
            for ($x = 1; $x <= $this->gridSize; $x++) {
                for ($squareSize = 1; $squareSize <= $this->gridSize - max($x,$y); $squareSize++) {
                    $sum = $this->gridSum($x, $y, $squareSize);
                    if ($maxSum < $sum) {
                        $mx = $x;
                        $my = $y;
                        $ms = $squareSize;
                        $maxSum = $sum;
                    }

                }
            }
        }
        return "$mx,$my,$ms";
    }

    private
    function gridSum(int $x, int $y, int $size)
    {
        $size -= 1;
        $A = $this->gridSum[$y - 1][$x - 1];
        $B = $this->gridSum[$y - 1][$x + $size];
        $C = $this->gridSum[$y + $size][$x - 1];
        $D = $this->gridSum[$y + $size][$x + $size];
        return $D - $C - $B + $A;
    }

    private
    function calculateGridPowerlevels()
    {
        for ($y = 1; $y <= $this->gridSize; $y++) {
            $this->grid[$y] = [];
            for ($x = 1; $x <= $this->gridSize; $x++) {
                $rackID = $x + 10;
                $power = ($rackID * $y + $this->serial) * $rackID;
                $power = ($power / 100) % 10;
                $this->grid[$y][$x] = $power - 5;
            }
        }
    }

    // see https://en.wikipedia.org/wiki/Summed-area_table
    private
    function summedAreaTable()
    {
        $this->gridSum[0] = array_fill(0, $this->gridSize + 1, 0);
        for ($y = 1; $y <= $this->gridSize; $y++) {
            $this->gridSum[$y] = [0];
            for ($x = 1; $x <= $this->gridSize; $x++) {
                $this->gridSum[$y][$x] = $this->grid[$y][$x];
                $this->gridSum[$y][$x] += $this->gridSum[$y - 1][$x];
                $this->gridSum[$y][$x] += $this->gridSum[$y][$x - 1];
                $this->gridSum[$y][$x] -= $this->gridSum[$y - 1][$x - 1];
            }
        }
    }


}