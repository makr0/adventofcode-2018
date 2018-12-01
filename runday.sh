#!/usr/bin/env php
<?php

use Aoc2018\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Debug\Debug;

set_time_limit(0);

require 'vendor/autoload.php';
require 'config/bootstrap.php';

$command = 'aoc2018:day'.$_SERVER['argv'][1];
$input = new ArgvInput([$_SERVER['argv'][0],$command]);
$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$application = new Application($kernel);
$application->run($input);
