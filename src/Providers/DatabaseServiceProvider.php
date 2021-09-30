<?php

declare(strict_types=1);

namespace App\Providers;

use Pollen\Database\DatabaseManagerInterface;
use Pollen\Kernel\Container\BootableServiceProvider;

class DatabaseServiceProvider extends BootableServiceProvider
{
    public function boot(): void
    {
        /** @var DatabaseManagerInterface $db * /
        $db = $this->app->get(DatabaseManagerInterface::class);
        /**/
    }
}
