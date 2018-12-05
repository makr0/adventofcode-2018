<?php

namespace Aoc2018\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day05Command extends Command
{
    protected static $defaultName = 'aoc2018:day05';
    /** @var OutputInterface */
    private $output;

    protected function configure() {
        $this
            ->setDescription('Day 5: Alchemical Reduction');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->output = $output;
        $this->output->writeln($this->getDescription());
        $units = str_split(file_get_contents('php://stdin'));

        $result1 = $this->part1($units);
        $output->writeln("Remaining Units (part1): $result1"); // toolow: 10330, accepted: 10762

        $result2 = $this->part2($units);
        $output->writeln("Shortest possible Polymer (part2): $result2"); // accepted: 6946
    }

    private function part1($units) {
        $this->output->writeln("Units in Input: ".count($units)); //
        while($this->removeNextPair($units)){
        };
        $this->output->writeln(count($units));
        return count($units);
    }

    private function part2($units) {
        $this->output->writeln("Units in Input: ".count($units)); //
        $types = array_unique(array_map('strtoupper',$units));

        sort($types);
        $this->output->write('Types in input: ');
        foreach ($types as $type) {
            $this->output->write($type);
        }
        $this->output->write("\r\n");
        $minlength = count($units);
        foreach($types as $type) {
            $this->output->write("Testing $type");
            $units_minus_type = array_filter($units,function($a) use($type) {
                return strtoupper($a) != $type;
            });
            $this->output->write('['.count($units_minus_type).'] => ');
            while($this->removeNextPair($units_minus_type));
            $minlength = min($minlength,count($units_minus_type));
            $this->output->writeln(count($units_minus_type)." best: $minlength");
        }
        return $minlength;
    }

    private function removeNextPair(array &$units) {
        foreach ($units as $index => $unit) {
            if(!isset($units[$index+1])) break;
            $nextUnit = $units[$index+1];
            if(  $unit != $nextUnit
                && (     strtolower($unit) == $nextUnit
                      || strtoupper($unit) == $nextUnit )
            ) {
                array_splice($units, $index,2);
                return true;
            }
        }
        return false;
    }

}