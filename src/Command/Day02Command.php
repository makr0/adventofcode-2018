<?php
namespace Aoc2018\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day02Command extends Command
{
    protected static $defaultName = 'aoc2018:day02';
    private $output;

    protected function configure()
    {
        $this
        ->setDescription('Day 2: Inventory Management System');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $lines = array_map('trim',file('php://stdin'));

        $result1 = $this->part1($lines);
        $result2 = $this->part2($lines);

        $output->writeln("checksum (part1): $result1");
        $output->writeln("common chars (part2): $result2");
    }

    private function part1($lines) {
        $letters=[2=>0,3=>0];
        foreach($lines as $line) {
            $bins=[];
            $chars = str_split($line);
            foreach($chars as $char) {
                $bins[$char] = isset($bins[$char]) ?$bins[$char]:0;
                $bins[$char]++;
            }
            $bins = array_flip($bins);
            for($i=2;$i<=3;$i++) {
                if(isset($bins[$i])) $letters[$i]++;
            }
        }
        return $letters[2] * $letters[3];
    }

    private function part2($lines) {
        while($id1 = array_pop($lines)) {
            foreach($lines as $id2) {
                $distance = levenshtein($id1,$id2,99,1,99);
                if($distance == 1) {
                    return $this->sameChars($id1,$id2);
                }
            }
        }
        return '--ERROR--';

    }

    private function sameChars($id1,$id2) {
        $result = [];
        $id1=str_split($id1);
        $id2=str_split($id2);
        foreach($id1 as $i => $char) {
            if($char == $id2[$i]) $result[]=$char;
        }
        return implode('',$result);
    }
}