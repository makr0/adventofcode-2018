<?php

namespace Aoc2018\Classes;

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
    }

    public function idle()
    {
        return $this->work_left==0;
    }

    public function getTask()
    {
        return $this->task;
    }

    public function tick()
    {
        if($this->work_left > 0) {
            $this->work_left--;
        }
    }
}