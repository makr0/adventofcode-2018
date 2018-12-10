<?php

namespace Aoc2018\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class DailyBase extends Command
{
    protected $AocName = 'aoc2018:dayXX';
    protected $AocDescription = "DayXX: Answer to the Ultimate Question of Life, the Universe, and Everything";
    /** @var OutputInterface */
    protected $output;

    public function __construct(string $name = null) {
        $this->setName($this->AocName);
        parent::__construct();
    }

    protected function configure() {
        $this->setDescription($this->AocDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->output = $output;
        $this->output->writeln($this->getDescription());
        $input = $this->parseInput($this->getInput());
        $output->writeln("Part1: ".$this->part1($input));
        $output->writeln("Part2: ".$this->part2($input));
    }
    protected function parseInput($input) {
        return array_map('trim',$input);
    }

    protected function getInput() {
        return file('php://stdin');
    }
     

    protected function part1($input) {
        return 42;
    }

    protected function part2($input) {
        return 'not Implemented';
    }
}