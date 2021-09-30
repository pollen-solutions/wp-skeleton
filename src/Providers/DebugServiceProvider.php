<?php

declare(strict_types=1);

namespace App\Providers;

use Pollen\Debug\DebugManagerInterface;
use Pollen\Kernel\Container\BootableServiceProvider;
use Pollen\Support\Env;

class DebugServiceProvider extends BootableServiceProvider
{
    public function boot(): void
    {
        /** @var DebugManagerInterface $debug */
        $debug = $this->app->get(DebugManagerInterface::class);

        if (Env::inDev()) {
            $debug->errorHandler()->enable();
            $debug->debugBar()->enable();
        }
    }
}
