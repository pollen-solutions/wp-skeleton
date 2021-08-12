<?php

declare(strict_types=1);

namespace App\Providers;

use Pollen\Container\BootableServiceProvider;
use Pollen\Log\LogManagerInterface;
use Pollen\Support\Proxy\AppProxy;

class LogServiceProvider extends BootableServiceProvider
{
    use AppProxy;

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        /** @var LogManagerInterface $log */
        $log = $this->getContainer()->get(LogManagerInterface::class);
        $log->setDefaultStoragePath($this->app()->getBasePath('var/log'));
    }
}
