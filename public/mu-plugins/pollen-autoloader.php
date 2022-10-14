<?php

declare(strict_types=1);

use Pollen\WpKernel\WpApplication;

if (! class_exists(WpApplication::class)) {
    return;
}

add_action('muplugins_loaded', function () {
    if ($app = WpApplication::getInstance()) {
        $app->build();
    }
}, 0);
