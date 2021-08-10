<?php

declare(strict_types=1);

namespace App\Providers;

use Pollen\Asset\AssetManagerInterface;
use Pollen\Container\BootableServiceProvider;

class AssetServiceProvider extends BootableServiceProvider
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        /** @var AssetManagerInterface $asset * /
        $asset = $this->getContainer()->get(AssetManagerInterface::class);
        /**/
    }
}
