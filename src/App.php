<?php

declare(strict_types=1);

namespace App;

use App\Providers\AssetServiceProvider as AppAssetServiceProvider;
use App\Providers\DebugServiceProvider as AppDebugServiceProvider;
use App\Providers\RoutingServiceProvider as AppRoutingServiceProvider;
use App\Providers\ViewServiceProvider as AppViewServiceProvider;
use Pollen\Asset\AssetServiceProvider;
use Pollen\Debug\DebugServiceProvider;
use Pollen\Routing\RoutingServiceProvider;
use Pollen\View\ViewServiceProvider;
use Pollen\ViewExtends\ViewExtendsServiceProvider;
use Pollen\WpKernel\WpApplication;

class App extends WpApplication
{
    public function getServiceProviders(): array
    {
        return [
            // Components
            AssetServiceProvider::class,
            DebugServiceProvider::class,
            RoutingServiceProvider::class,
            ViewServiceProvider::class,
            ViewExtendsServiceProvider::class,
            // Application
            AppAssetServiceProvider::class,
            AppDebugServiceProvider::class,
            AppRoutingServiceProvider::class,
            AppViewServiceProvider::class
        ];
    }
}