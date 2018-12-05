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
        $units = file_get_contents('php://stdin');

        $result1 = $this->part1($units);
        $output->writeln("Remaining Units (part1): $result1"); // toolow: 10330, accepted: 10762

        $result2 = $this->part2($units);
        $output->writeln("Shortest possible Polymer (part2): $result2"); // accepted: 6946
    }

    private function part1($units) {
        $this->output->writeln("Units in Input: ".strlen($units)); //
        $units = $this->removePairs($units);
        return strlen($units);
    }

    private function part2($units) {
        $this->output->writeln("Units in Input: ".strlen($units)); //
        $types = array_unique(array_map('strtoupper',str_split($units)));

        sort($types);
        $this->output->write('Types in input: ');
        foreach ($types as $type) {
            $this->output->write($type);
        }
        $this->output->write("\r\n");
        $minlength = strlen($units);
        foreach($types as $type) {
            $this->output->write("Testing $type");
            $units_minus_type = preg_replace("~$type|".strtolower($type)."~",'',$units);
            $this->output->write('['.strlen($units_minus_type).'] => ');
            $units_minus_type = $this->removePairs($units_minus_type);
            $minlength = min($minlength,strlen($units_minus_type));
            $this->output->writeln(strlen($units_minus_type)." best: $minlength");
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