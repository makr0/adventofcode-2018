<?php

namespace Aoc2018\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Day03Command extends DailyBase
{
    protected $AocName = 'aoc2018:day03';
    protected $AocDescription = "Day 3: No Matter How You Slice It";

    protected function part1($lines) {
        $claims = $this->parseClaims($lines );
        $fabric = $this->markFabric($claims);
        $multiClaimed=0;
        array_walk_recursive($fabric, function ($value, $key) use(&$multiClaimed) {
            if($value > 1 ) $multiClaimed++;
        });

        return $multiClaimed;
    }

    protected function part2($lines) {
        $claims = $this->parseClaims($lines );
        $fabric = $this->markFabric($claims);
        foreach ($claims as $claim) {
            $tainted = 0;
            for ($x = $claim['start'][0]; $x < $claim['end'][0]; $x++) {
                for ($y = $claim['start'][1]; $y < $claim['end'][1]; $y++) {
                    if($fabric[$x][$y]>1) $tainted=1;
                }
            }
            if($tainted==0) return $claim['id'];
        }
        return '--ERROR--';
    }

    /**
     * @param $lines
     * @param array $claims
     * @return array
     */
    private function parseClaims(array $lines): array {
        $claims = [];
        foreach ($lines as $line) {
            $parts = explode(' ', str_replace(':', '', $line));
            $start = array_map('intval', explode(',', $parts[2]));
            $claim = [
                'id' => $parts[0],
                'start' => [$start[0], $start[1]]
            ];
            $claim['size'] = array_map('intval', explode('x', $parts[3]));
            $claim['end'] = [
                $claim['start'][0] + $claim['size'][0],
                $claim['start'][1] + $claim['size'][1]
            ];
            $claims[] = $claim;
        }
        return $claims;
    }

    /**
     * @param array $claims
     * @return array
     */
    private function markFabric(array $claims): array {
        $fabric = [];
        $fabricSize = [1000, 1000];
        for ($x = 0; $x <= $fabricSize[0]; $x++) {
            for ($y = 0; $y <= $fabricSize[1]; $y++) {
                $fabric[$x][$y] = 0;
            }
        }
        foreach ($claims as $claim) {
            for ($x = $claim['start'][0]; $x < $claim['end'][0]; $x++) {
                for ($y = $claim['start'][1]; $y < $claim['end'][1]; $y++) {
                    $fabric[$x][$y] = $fabric[$x][$y] + 1;
                }
            }
        }
        return $fabric;
    }
}