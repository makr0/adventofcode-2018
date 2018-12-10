<?php

namespace Aoc2018\Command\Day07;

class Worker
{
    private $task;
    private $work_left;

    public function __construct()
    {
        $this->task = '.';
        $this->work_left=0;
    }

    public function start($task)
    {
        if($task == false) return;
        $this->task=$task;
        $this->work_left=ord($task) - ord('A')+61;
        dump('Worker started '.$this->task.' with duration '.$this->work_left);
    }

    public function idle()
    {
        return $this->task == '.';
    }

    public function getTask()
    {
        return $this->task;
    }

    public function tick()
    {
        if($this->work_left > 0) {
            $this->work_left--;
            if($this->work_left==0) {
                dump('Worker finished '.$this->task);
                $this->task='.';
            }
        }
    }
}