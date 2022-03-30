<?php

declare(strict_types=1);

use Pollen\Debug\DebugManagerInterface;
use Pollen\Kernel\ApplicationInterface;
use Pollen\Support\Env;

return static function (DebugManagerInterface $debug, ApplicationInterface $app) {
    if (Env::inDev()) {
        $debug->errorHandler()->enable();
        //$debug->debugBar()->enable();
    }
};
