<?php

declare(strict_types=1);

namespace App\Providers;

use Pollen\Asset\AssetManagerInterface;
use Pollen\Kernel\Container\BootableServiceProvider;

class AssetServiceProvider extends BootableServiceProvider
{
    public function boot(): void
    {
        /** @var AssetManagerInterface $asset * /
        $asset = $this->app->get(AssetManagerInterface::class);
        /**/
    }
}
