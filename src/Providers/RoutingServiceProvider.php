<?php

declare(strict_types=1);

namespace App\Providers;

use Pollen\Routing\RouterInterface;
use Pollen\Support\Proxy\AssetProxy;
use Pollen\Kernel\Container\BootableServiceProvider;

class RoutingServiceProvider extends BootableServiceProvider
{
    use AssetProxy;

    public function boot(): void
    {
        /** @var RouterInterface $router * /
        $router = $this->app->get(RouterInterface::class);

        $router->get('/', function () {
            $this->asset()->enqueueCharset();
            $this->asset()->enqueueTitle('Welcome');

            return view('index', ['name' => 'John Doe']);
        });
        /**/
    }
}
