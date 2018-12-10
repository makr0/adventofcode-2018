<?php

namespace Aoc2018\Command;


class Day08Command extends DailyBase
{
    protected $AocName = 'aoc2018:day08';
    protected $AocDescription = "Day 8: Memory Maneuver";

    protected function parseInput($input) {
        return array_map('intval',explode(' ',$input[0]));
    }

    protected function part1($input) {
        $nodes = $this->parseTree($input);
        return $nodes['s'];
    }

    protected function part2($input) {
        $rootNode = $this->parseTree($input);
        return $this->sumIndexed($rootNode);
    }
    private function sumIndexed($node) {
        // no children: return sum of my metadata
        if(count($node['c']) == 0) {
            return array_sum($node['m']);
        }
        $sum=0;
        foreach ($node['m'] as $metaNumber) {
            $index = $metaNumber-1; // child array is zero based
            if (isset($node['c'][$index])) {
                $sum += $this->sumIndexed($node['c'][$index]);
            }
        }
        return $sum;
    }

    // returns Array ['c' => array of child nodes
    //                'm' => array of metadata entries of this node
    //                's' => sum of Metadata and all child nodes]
    private function parseTree(&$tail) {
        $children=[];
        $metadata=[];
        $num_children = array_shift($tail);
        $num_metadata = array_shift($tail);
        $sum_meta = 0;
        for($i=0;$i<$num_children;$i++) {
            $node = $this->parseTree($tail);
            $children[]=$node;
            $sum_meta += $node['s'];
        }
        for($i=0;$i<$num_metadata;$i++) {
            $metadata[]=array_shift($tail);
        }
        $sum_meta += array_sum($metadata);
        return ['c'=>$children,'m'=>$metadata,'s'=>$sum_meta];
    }
}