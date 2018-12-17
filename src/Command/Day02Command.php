<?php
namespace Aoc2018\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day02Command extends DailyBase
{
    protected $AocName = 'aoc2018:day02';
    protected $AocDescription = "Day 2: Inventory Management System";

    protected function part1($lines) {
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

    protected function part2($lines) {
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