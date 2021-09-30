<?php

declare(strict_types=1);

namespace App\Providers;

use Pollen\Support\Env;
use Pollen\View\ViewManagerInterface;
use Pollen\Kernel\Container\BootableServiceProvider;

class ViewServiceProvider extends BootableServiceProvider
{
    public function boot(): void
    {
        /** @var ViewManagerInterface $view */
        $view = $this->app->get(ViewManagerInterface::class);

        $view
            // Use plates|twig as view engine
            ->setDefaultEngine('plates')
            ->setDirectory($this->app->getBasePath('/resources/views'))
            ->setCacheDir(!Env::inDev() ? $this->app->getBasePath('/var/cache/views') : null);
    }
}
