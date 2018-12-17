<?php

namespace Aoc2018\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Stopwatch\Stopwatch;

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
        $timer = new Stopwatch(true);
        $this->setupOutput($output);
        $this->output->writeln('<day>'.$this->getDescription().'</day>');
        $timer->start('getInput');
        $input = $this->parseInput($this->getInput());
        $inputtime = $timer->stop('getInput')->getDuration();
        $timer->start('part1');
        $output->writeln("<part>Part1</part> ".$this->part1($input));
        $part1time=$timer->stop('part1')->getDuration();
        $timer->start('part2');
        $output->writeln("<part>Part2</part> ".$this->part2($input));
        $part2time=$timer->stop('part2')->getDuration();
        $this->output->writeln(sprintf('i: %dms, 1: %dms, 2: %dms',$inputtime, $part1time, $part2time));
    }

    protected function parseInput($input) {
        return array_map('trim',$input);
    }

    protected function getInput() {
        stream_set_blocking(STDIN, 0);
        $stdin = file('php://stdin');
        if(!$stdin) {
            $commandPattern = '~Day(\d+)Command~';
            if (preg_match($commandPattern, static::class, $match)) {
                $inputfile = 'data/'.$match[1].'.txt';
                if(!file_exists(__DIR__ .'/../../'.$inputfile)) {
                    throw new \UnexpectedValueException("no input.\nTried to read from $inputfile");
                }
                $this->output->writeln('no input in stdin, using file '.$inputfile );
                $stdin = file($inputfile);
            } else {
                throw new \UnexpectedValueException("no input.\ncould not guess filename, Your CommandName was unexpected. Expected: $commandPattern");

            }

        }
        return $stdin;
    }
     

    protected function part1($input) {
        return 'not Implemented';
    }

    protected function part2($input) {
        return 'not Implemented';
    }

    /**
     * @param OutputInterface $output
     */
    protected function setupOutput(OutputInterface $output): void
    {
        $outputStyle = new OutputFormatterStyle('red', 'default', array('bold'));
        $output->getFormatter()->setStyle('day', $outputStyle);
        $outputStyle = new OutputFormatterStyle('yellow', 'default', array('bold'));
        $output->getFormatter()->setStyle('part', $outputStyle);
        $this->output = $output;
    }
}