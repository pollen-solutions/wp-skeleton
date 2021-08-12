<?php

declare(strict_types=1);

namespace App;

use App\Providers\AssetServiceProvider as AppAssetServiceProvider;
use App\Providers\DatabaseServiceProvider as AppDatabaseServiceProvider;
use App\Providers\DebugServiceProvider as AppDebugServiceProvider;
use App\Providers\LogServiceProvider as AppLogServiceProvider;
use App\Providers\RoutingServiceProvider as AppRoutingServiceProvider;
use App\Providers\ViewServiceProvider as AppViewServiceProvider;
use Pollen\Asset\AssetServiceProvider;
use Pollen\Database\DatabaseServiceProvider;
use Pollen\Debug\DebugServiceProvider;
use Pollen\Log\LogServiceProvider;
use Pollen\Routing\RoutingServiceProvider;
use Pollen\View\ViewServiceProvider;
use Pollen\ViewExtends\ViewExtendsServiceProvider;
use Pollen\WpDatabase\WpDatabaseServiceProvider;
use Pollen\WpKernel\WpApplication;

class App extends WpApplication
{
    public function getServiceProviders(): array
    {
        return [
            // Components
            AssetServiceProvider::class,
            DatabaseServiceProvider::class,
            DebugServiceProvider::class,
            LogServiceProvider::class,
            RoutingServiceProvider::class,
            ViewServiceProvider::class,
            ViewExtendsServiceProvider::class,
            WpDatabaseServiceProvider::class,
            // Application
            AppAssetServiceProvider::class,
            AppDatabaseServiceProvider::class,
            AppDebugServiceProvider::class,
            AppLogServiceProvider::class,
            AppRoutingServiceProvider::class,
            AppViewServiceProvider::class
        ];
    }
}