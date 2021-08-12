<?php

declare(strict_types=1);

namespace App\Providers;

use Pollen\Container\BootableServiceProvider;
use Pollen\Database\DatabaseManagerInterface;

class DatabaseServiceProvider extends BootableServiceProvider
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        /** @var DatabaseManagerInterface $db * /
        $db = $this->getContainer()->get(DatabaseManagerInterface::class);
        /**/
    }
}
