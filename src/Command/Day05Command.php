<?php

namespace Aoc2018\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day05Command extends DailyBase
{
    protected $AocName = 'aoc2018:day05';
    protected $AocDescription = "Day 5: Alchemical Reduction";

    protected function parseInput($input) {
        return trim($input[0]);
    }

    protected function part1($units) {
        $units = $this->removePairs($units);
        return strlen($units);
    }

    protected function part2($units) {
        $types = array_unique(array_map('strtoupper',str_split($units)));

        sort($types);
        $minlength = strlen($units);
        foreach($types as $type) {
            $units_minus_type = preg_replace("~$type|".strtolower($type)."~",'',$units);
            $units_minus_type = $this->removePairs($units_minus_type);
            $minlength = min($minlength,strlen($units_minus_type));
        }
        return $minlength;
    }

    private function removePairs($units) {
        $length_before = strlen($units);
        $types = array_unique(array_map('strtolower',str_split($units)));
        foreach ($types as $type ) {
            $typeUpper = strtoupper($type);
            $regex = "~$type$typeUpper|$typeUpper$type~";
            do {
                $units = preg_replace($regex,'',$units,-1,$replacements);
            } while($replacements);
        }
        if(strlen($units)==$length_before) return $units;
        else return $this->removePairs($units);
    }

}