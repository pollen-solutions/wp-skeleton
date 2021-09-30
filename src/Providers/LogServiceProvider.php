<?php

declare(strict_types=1);

namespace App\Providers;

use Pollen\Log\LogManagerInterface;
use Pollen\Kernel\Container\BootableServiceProvider;

class LogServiceProvider extends BootableServiceProvider
{
    public function boot(): void
    {
        /** @var LogManagerInterface $log */
        $log = $this->app->get(LogManagerInterface::class);
        $log->setDefaultStoragePath($this->app->getBasePath('var/log'));
    }
}
