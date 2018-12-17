<?php

namespace Aoc2018\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Aoc2018\Classes\Worker;

class Day07Command extends DailyBase
{
    protected $AocName = 'aoc2018:day07';
    protected $AocDescription = "Day 7: The Sum of Its Parts";

    protected function part1($tasks) {
        $order = '';
        while($task = $this->nextFreeTask($tasks)) {
            $order.=$task;
            $tasks=$this->removeTask($task,$tasks);
        }
        return $order;
    }

    protected function part2($tasks) {
        for($i=0;$i<5;$i++) {
            $workers[$i] = new Worker();
            if($nextTask = $this->nextFreeTask($tasks)) {
                $workers[$i]->start($nextTask);
                $tasks[$nextTask] = '.';
            }
        }

        $timeTaken = 0;
        while(!($this->nextFreeTask($tasks)) && $this->busyWorkers($workers) > 0) {
            $timeTaken++;
            foreach($workers as $worker) {
                if(!$worker->idle()) {
                    $worker->tick();
                    if($worker->idle()) {
                        $tasks = $this->removeTask($worker->getTask(),$tasks);
                    }
                }
            }
            foreach($workers as $worker) {
                if($worker->idle() && $nextTask = $this->nextFreeTask($tasks)) {
                    $worker->start($nextTask);
                    $tasks[$nextTask] = '.';
                }
            }
        }
        return $timeTaken;
    }

    private function busyWorkers(array $workers)   
    {
        $busy = 0;
        foreach($workers as $worker) {
            $busy += $worker->idle() ? 0:1;
        }
        return $busy;
    }

    private function nextFreeTask(array $tasks)     
    {
        foreach ($tasks as $task => $deps) {
            if($deps == '') return $task;
        }
        return false;
    }
    private function removeTask(string $task, array $tasks)
    {
        foreach ($tasks as $i => &$deps) {
            $deps = str_replace($task, '',$deps);
        }
        unset($tasks[$task]);
        return $tasks;
    }


    // returns a list of tasks(keys) with dependent tasks (values)
    protected function parseInput($lines) {
        $tasks = [];
        foreach ($lines as $line ) {
            preg_match('/Step ([A-Z]) must be finished before step ([A-Z])/',$line,$matches);
            list(,$dependsOn,$task)=$matches;
            // we need to know all tasks, dependent or not
            if(!isset($tasks[$task])) $tasks[$task] = '';
            if(!isset($tasks[$dependsOn])) $tasks[$dependsOn] = '';
            $tasks[$task] .= $dependsOn;
        }
        ksort($tasks);
        return $tasks;
    }
        

}