<?php

namespace Aoc2018\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day10Command extends DailyBase
{
    protected $AocName = 'aoc2018:day10';
    protected $AocDescription = "Day 10: The Stars Align";
    private $starsAlignAt = 0;

    protected function parseInput($input) {
        $inputLines = parent::parseInput($input);
        $stars = [];
        foreach ($inputLines as $inputLine) {
            preg_match('~position=<(.+),(.+)> velocity=<(.+),(.+)>~',$inputLine,$matches);
            $stars[] = ['pos'=>[(int)$matches[1],(int)$matches[2]], 'vel'=>[(int)$matches[3],(int)$matches[4]]];
        }
        return $stars;
    }

    protected function part1($stars) {
        $lastBoxSize = $this->boundingBoxArea($stars);
        foreach(range(0,200000) as $i) {
            foreach ($stars as &$star) {
                $star['pos'][0] += $star['vel'][0];
                $star['pos'][1] += $star['vel'][1];
            }
            $boxSize = $this->boundingBoxArea($stars);
            if ($lastBoxSize < $boxSize) {
                $this->starsAlignAt = $i;
                break;
            }
            $lastBoxSize = $boxSize;
        }
        // move one step back
        foreach ($stars as &$star) {
            $star['pos'][0] -= $star['vel'][0];
            $star['pos'][1] -= $star['vel'][1];
        }

        return $this->plotSky($stars);
    }
    protected function part2($input)
    {
        return $this->starsAlignAt;
    }

    private function plotSky($stars) {
        list($minX,$minY,$maxX,$maxY) = $this->boundingBox($stars);
        $sky = '';
        foreach(range($minY,$maxY) as $y) {
            foreach(range($minX,$maxX) as $x) {
                $star_set=false;
                foreach ($stars as $star) {
                    if(   $star['pos'][0] == $x
                       && $star['pos'][1] == $y){
                        $star_set=true;
                    }
                }
                $sky .= $star_set ? '#':' ';
            }
            $sky.="\n";
        }
        return $sky;
    }

    private function boundingBox($stars)
    {
        $minX=$maxX=$stars[0]['pos'][0];
        $minY=$maxY=$stars[0]['pos'][1];
        foreach ($stars as $star) {
            $minX=min($minX,$star['pos'][0]);
            $minY=min($minY,$star['pos'][1]);
            $maxX=max($maxX,$star['pos'][0]);
            $maxY=max($maxY,$star['pos'][1]);
        }
        return [$minX,$minY,$maxX,$maxY];

    }

    private function boundingBoxArea($stars)
    {
        list($minX,$minY,$maxX,$maxY) = $this->boundingBox($stars);
        return ($maxX-$minX)*($maxY-$minY);
    }

}