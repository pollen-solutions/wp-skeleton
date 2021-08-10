<?php

declare(strict_types=1);

namespace App\Providers;

use Pollen\Container\BootableServiceProvider;
use Pollen\Routing\RouterInterface;
use Pollen\Support\Proxy\AssetProxy;

class RoutingServiceProvider extends BootableServiceProvider
{
    use AssetProxy;

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        /** @var RouterInterface $router * /
        $router = $this->getContainer()->get(RouterInterface::class);

        $router->get(
            '/',
            function () {
                $this->asset()->enqueueCharset();
                $this->asset()->enqueueTitle('Welcome');

                return view('index', ['name' => 'John Doe']);
            }
        );
        /**/
    }
}
