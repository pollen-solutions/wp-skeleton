<?php

declare(strict_types=1);

namespace App\Providers;

use Pollen\Container\BootableServiceProvider;
use Pollen\Debug\DebugManagerInterface;
use Pollen\Support\Env;

class DebugServiceProvider extends BootableServiceProvider
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        /** @var DebugManagerInterface $debug */
        $debug = $this->getContainer()->get(DebugManagerInterface::class);

        if (Env::inDev()) {
            $debug->errorHandler()->enable();
            $debug->debugBar()->enable();
        }
    }
}
