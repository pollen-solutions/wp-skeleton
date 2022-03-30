<?php

declare(strict_types=1);

use Pollen\Console\ConsoleInterface;
use Pollen\Kernel\ApplicationInterface;
use Pollen\Console\Commands\DemoStyleCommand;

return static function (ConsoleInterface $console, ApplicationInterface $app) {
    $console->addCommand(DemoStyleCommand::class);
};