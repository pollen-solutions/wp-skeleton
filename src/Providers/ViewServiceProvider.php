<?php

declare(strict_types=1);

namespace App\Providers;

use Pollen\Container\BootableServiceProvider;
use Pollen\Support\Env;
use Pollen\View\ViewManagerInterface;

class ViewServiceProvider extends BootableServiceProvider
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        /** @var ViewManagerInterface $view */
        $view = $this->getContainer()->get(ViewManagerInterface::class);

        $view
            // Use plates|twig as view engine
            ->setDefaultEngine('plates')
            ->setDirectory(dirname(__DIR__, 2) . '/resources/views')
            ->setCacheDir(!Env::inDev() ? dirname(__DIR__, 2) . '/var/cache/views' : null);
    }
}
